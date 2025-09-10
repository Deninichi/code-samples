<?php

namespace App\Services;

use App\Http\Resources\DocumentResource;
use App\Http\Resources\FloorplanResource;
use App\Http\Resources\ProjectResource;
use App\Jobs\SendDocumentWebhookJob;
use App\Jobs\SendFloorplanWebhookJob;
use App\Jobs\SendProjectWebhookJob;
use App\Models\Document;
use App\Models\Floorplan;
use App\Models\Project;
use App\Models\Team;
use App\Models\Webhook;
use Illuminate\Support\Facades\Log;

class WebhookService
{
	protected SubscriptionAccessService $accessService;

	public function __construct(SubscriptionAccessService $accessService)
	{
		$this->accessService = $accessService;
	}

	/**
	 * Send webhook for model events
	 */
	public function sendWebhook($model, string $event): void
	{
		// Get all active webhooks for all teams
		$webhooks = Webhook::with('team')
		                   ->where('is_active', true)
		                   ->whereJsonContains('events', $event)
		                   ->get();

		foreach ($webhooks as $webhook) {
			Log::debug("Sending webhook {$webhook->id} for event {$event}");

			$jobClass = match (get_class($model)) {
				Project::class => SendProjectWebhookJob::class,
				Floorplan::class => SendFloorplanWebhookJob::class,
				Document::class => SendDocumentWebhookJob::class,
				default => throw new \InvalidArgumentException("Unsupported model type: ".get_class($model))
			};

			$jobClass::dispatch($model->id, $model->getWebhookChanges(), $webhook->id, $event);
		}
	}

	/**
	 * Send webhook to a specific webhook endpoint
	 */
	public function sendToSpecificWebhook($model, Webhook $webhook, string $event): void
	{
		try {
			$modelType = match (get_class($model)) {
				Project::class => 'project',
				Floorplan::class => 'floorplan',
				Document::class => 'document',
				default => throw new \InvalidArgumentException("Unsupported model type: ".get_class($model))
			};

			$payload = $this->buildWebhookPayload($model, $webhook->team, $event, $modelType);

			\Spatie\WebhookServer\WebhookCall::create()
			                                 ->url($webhook->url)
			                                 ->payload($payload)
			                                 ->useSecret($webhook->getSecret())
			                                 ->dispatch();

			$modelId = $model->id;
			Log::info("{$modelType} webhook sent successfully", [
				"{$modelType}_id" => $modelId,
				'webhook_id' => $webhook->id,
				'event' => $event,
				'url' => $webhook->url
			]);

		} catch (\Exception $e) {
			$modelId = $model->id;
			$modelType = match (get_class($model)) {
				Project::class => 'project',
				Floorplan::class => 'floorplan',
				Document::class => 'document',
				default => 'unknown'
			};
			Log::error("Failed to send {$modelType} webhook", [
				"{$modelType}_id" => $modelId,
				'webhook_id' => $webhook->id,
				'event' => $event,
				'url' => $webhook->url,
				'error' => $e->getMessage()
			]);
		}
	}

	/**
	 * Build webhook payload for models
	 */
	protected function buildWebhookPayload(
		$model,
		?Team $team = null,
		string $event = '',
		string $modelType = ''
	): array {
		$payload = [
			'event' => $event,
			'timestamp' => now()->toISOString(),
		];

		if ($team) {
			$payload['team_id'] = $team->id;

			// For deleted events, we can only provide minimal data since the model is gone
			if (str_ends_with($event, '.deleted')) {
				$payload[$modelType] = $this->getMinimalModelData($model, $modelType);
			} else {
				// Get full model data filtered by team's subscription level
				$modelData = $this->getModelResourceData($model, $modelType);
				$filteredModelData = $this->accessService->filterDataForTeam($team, $modelData, $modelType);

				// Add changes to the filtered model data for update events
				if (str_ends_with($event, '.updated')) {
					$filteredChanges = $this->filterChangesForTeam($model->getWebhookChanges(), $team, $modelType);
					$filteredModelData['changes'] = $filteredChanges;
				}

				$payload[$modelType] = $filteredModelData;
			}
		} else {
			// No team context - return minimal data
			$payload[$modelType] = $this->getMinimalModelData($model, $modelType);
		}

		return $payload;
	}

	/**
	 * Get model resource data
	 */
	protected function getModelResourceData($model, string $modelType): array
	{
		if ($modelType === 'project') {
			return (new ProjectResource($model))->toArray(request());
		} elseif ($modelType === 'floorplan') {
			return (new FloorplanResource($model))->toArray(request());
		} elseif ($modelType === 'document') {
			return (new DocumentResource($model))->toArray(request());
		}

		return [];
	}

	/**
	 * Get minimal model data for no-team context
	 */
	protected function getMinimalModelData($model, string $modelType): array
	{
		if ($modelType === 'project') {
			return [
				'id' => $model->id,
				'name' => $model->name,
			];
		} elseif ($modelType === 'floorplan') {
			return [
				'id' => $model->id,
				'name' => $model->name,
				'project_id' => $model->project_id,
			];
		} elseif ($modelType === 'document') {
			return [
				'id' => $model->id,
				'name' => $model->name,
				'file_url' => $model->file_url,
			];
		}

		return [];
	}

	/**
	 * Filter changes based on team's subscription access
	 */
	protected function filterChangesForTeam(array $changes, Team $team, string $modelType): array
	{
		$filteredChanges = [];

		foreach ($changes as $field => $change) {
			if ($this->accessService->isFieldAccessible($team, $field, $modelType)) {
				$filteredChanges[$field] = $change;
			}
		}

		return $filteredChanges;
	}
}

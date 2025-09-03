<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\Webhook;
use App\Services\WebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendProjectWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [10, 30, 60]; // Retry after 10s, 30s, 1min

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected int $projectId,
        protected array $changes = [],
        protected int $webhookId,
        protected string $event = 'project.updated'
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(WebhookService $webhookService): void
    {
        Log::debug("Sending project webhook job {$this->webhookId} for event {$this->event}");
        try {
            $project = Project::find($this->projectId);

            if (!$project) {
                Log::warning('Project not found for webhook job', [
                    'project_id' => $this->projectId
                ]);
                return;
            }

            $webhook = Webhook::findOrFail($this->webhookId);
            if ($webhook->shouldReceiveEvent($this->event)) {
                $webhookService->sendToSpecificWebhook($project, $webhook, $this->event);
            }

        } catch (\Exception $e) {
            Log::error('Failed to send project webhook', [
                'project_id' => $this->projectId,
                'webhook_id' => $this->webhookId,
                'event' => $this->event,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Project webhook job failed permanently', [
            'project_id' => $this->projectId,
            'error' => $exception->getMessage()
        ]);
    }
}

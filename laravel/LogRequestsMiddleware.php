<?php

namespace App\Http\Middleware;

use App\Jobs\ProcessRequestStatistics;
use App\Jobs\ProcessTeamApiRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class LogRequests
{
	public function handle(Request $request, Closure $next)
	{
		try {
			$response = $next($request);

			if ($response->getStatusCode() === 200) {
				$this->logSuccessfulRequest($request);
			}

			return $response;

		} catch (Throwable $e) {
			if ($request->is('api/*')) {
				$resource = ltrim(str_replace('api/v1', '', $request->path()), '/');

				Log::channel('api_error')->error('API Exception', [
					'resource' => $resource,
					'method' => $request->method(),
					'url' => $request->fullUrl(),
					'ip' => $request->ip(),
					'headers' => $request->headers->all(),
					'payload' => $request->all(),
					'exception' => $e,
				]);
			}

			throw $e;
		}
	}

	private function logSuccessfulRequest(Request $request): void
	{
		$requestData = [
			'path' => $request->path(),
			'url' => $request->fullUrl(),
		];

		// Check if request has team (from TeamTokenMiddleware)
		if ($request->has('current_team')) {
			$team = $request->get('current_team');
			$token = $request->get('current_team_token');
			$requestData['team_id'] = $team->id;
			$requestData['user_id'] = null;
			$requestData['token_id'] = $token->id;

			// Log team API request for subscription tracking
			ProcessTeamApiRequest::dispatch([
				'team_id' => $team->id,
				'endpoint' => $request->path(),
				'requested_at' => now(),
				'token_id' => $token->id,
			]);
		} else {
			// Log regular user request
			$requestData['team_id'] = null;
			$requestData['user_id'] = $request->user() ? $request->user()->id : null;
		}

		ProcessRequestStatistics::dispatch($requestData);
	}

	public function terminate(Request $request, $response): void
	{
		try {
			$status = $response->getStatusCode();

			if ($status >= 400) {
				$resource = ltrim(str_replace('api/v1', '', $request->path()), '/');
				$logData = [
					'resource' => $resource,
					'method' => $request->method(),
					'url' => $request->fullUrl(),
					'ip' => $request->ip(),
					'headers' => $request->headers->all(),
					'payload' => $request->all(),
					'status' => $status,
				];

				Log::channel('api_error')->error('API Error', $logData);
			}
		} catch (Throwable $e) {
			Log::channel('api_error')->error('Log failure', [
				'exception' => $e,
			]);
		}
	}
}

<?php

namespace App\Jobs\SMS;

use App\Events\MessageSendSuccessfullyEvent;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Queue\{
    InteractsWithQueue,
    SerializesModels
};

class KaveNegarSendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param string $httpMethod
     * @param string $url
     * @param array $data
     */
    public function __construct(private string $httpMethod, private string $url, private array $data)
    {

    }

    /**
     * Execute the job.
     *
     * @param PendingRequest $request
     *
     * @return void
     */
    public function handle(PendingRequest $request)
    {
        try {
            $response = $request->{$this->httpMethod}($this->url, $this->data)->onError(function ($error) {
                throw new Exception($error, $error->status());
            });
            if ($response->successful()) {
                $results = $response->json();
                MessageSendSuccessfullyEvent::dispatch($results['entries']);
            }
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }
}

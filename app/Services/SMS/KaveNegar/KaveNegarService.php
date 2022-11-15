<?php

namespace App\Services\SMS\KaveNegar;

use App\Drivers\SMS\SMSContract;
use App\Events\MessageSendSuccessfullyEvent;
use App\Exceptions\KaveNegarException;
use App\Jobs\SMS\KaveNegarSendMessageJob;
use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;

class KaveNegarService implements SMSContract
{
    const SEND_SINGLE_MESSAGE = 'send';
    const CHECK_MESSAE_STATUS = 'status';

    private array $urls;

    protected PendingRequest $request;

    private string $apiKey;

    /**
     * KaveNegarService constructor.
     *
     * @param PendingRequest $request
     * @param array $kaveNegarConfig
     */
    public function __construct(PendingRequest $request, array $kaveNegarConfig)
    {
        $this->request = $request;
        $this->apiKey = $kaveNegarConfig['api-key'];
        $this->prepareUrls($kaveNegarConfig['endpoints']['v1']);

    }

    /**
     * @param string $message
     * @param array $receptors
     * @param string $sender
     * @param Carbon|null $date
     *
     * @return array
     */
    public function sendAsyncMessage(string $message, array $receptors, string $sender = '', Carbon $date = null): array
    {
        $body = prepareBodyRequest($receptors, $message, $sender);

        KaveNegarSendMessageJob::dispatch('get', $this->urls[self::SEND_SINGLE_MESSAGE], $body)->delay($date ?? now());

        return [
            'message' => __('sending_message_successful')
        ];
    }

    /**
     * @param string $message
     * @param array $receptors
     *
     * @param string $sender
     * @return array
     * @throws KaveNegarException
     */
    public function sendSyncMessage(string $message, array $receptors, string $sender = ''): array
    {
        $data = prepareBodyRequest($receptors, $message, $sender);
        $response = $this->request->get($this->urls[self::SEND_SINGLE_MESSAGE], $data)->onError(function ($error) {
            throw new KaveNegarException($error->json(), $error->status());
        });

        if ($response->successful()) {
            MessageSendSuccessfullyEvent::dispatch($response->json()['entries']);
        }

        return [
            'message' => $response->json()['return']['message']
        ];
    }

    /**
     * @param array $urls
     */
    private function prepareUrls(array $urls): void
    {
        foreach ($urls as $name => $url) {
            $this->urls[$name] = str_replace('{api-key}', $this->apiKey, $url);
        }
    }
}

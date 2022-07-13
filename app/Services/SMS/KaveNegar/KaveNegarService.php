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

    /**
     * @var array
     */
    private array $urls;

    /**
     * KaveNegarService constructor.
     *
     * @param PendingRequest $request
     * @param array $kaveNegarConfig
     */
    public function __construct(protected PendingRequest $request,  protected array $kaveNegarConfig)
    {
        $this->request = $request;
        $this->apiKey = $kaveNegarConfig['api-key'];
        $this->prepareUrls($kaveNegarConfig['endpoints']['v1']);

    }

    /**
     * @param string $message
     * @param string $sender
     * @param array $receptors
     * @param Carbon $date
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
     * @param string $sender
     * @param array $receptors
     *
     * @return array
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
    private function prepareUrls(array $urls)
    {
        foreach ($urls as $name => $url) {
            $this->urls[$name] = str_replace('{api-key}', $this->apiKey, $url);
        }
    }
}

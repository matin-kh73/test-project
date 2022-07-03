<?php

namespace App\Services\SMS\KaveNegar;

use App\Drivers\SMS\SMSContract;
use App\Events\MessageSendSuccessfullyEvent;
use App\Exceptions\KaveNegarException;
use App\Jobs\SMS\KaveNegarJob;
use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

class KaveNegarService implements SMSContract
{
    const SEND_SINGLE_MESSAGE = 'send';
    const CHECK_MESSAE_STATUS = 'status';

    /**
     * @var array
     */
    private array $urls;

    /**
     * @var PendingRequest
     */
    private $request;

    /**
     * @var mixed
     */
    private $apiKey;

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
     * @param string $sender
     * @param array $receptors
     * @param Carbon $date
     *
     * @return array
     */
    public function sendAsyncMessage(string $message, array $receptors, string $sender = '', Carbon $date = null): array
    {
        $body = prepareBodyRequest($receptors, $message, $sender, $date);

        KaveNegarJob::dispatch('get', $this->urls[self::SEND_SINGLE_MESSAGE], $body);

        return [
            'message' => __('sending_message_successful')
        ];
    }

    /**
     * @param string $message
     * @param string $sender
     * @param array $receptors
     * @param Carbon|null $date
     *
     * @return array
     */
    public function sendSyncMessage(string $message, array $receptors, string $sender = '', Carbon $date = null): array
    {
        $data = prepareBodyRequest($receptors, $message, $sender, $date);
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

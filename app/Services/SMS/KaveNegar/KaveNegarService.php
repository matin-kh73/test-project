<?php

namespace App\Services\SMS\KaveNegar;

use App\Jobs\SMS\KaveNegarJob;
use App\Services\SMS\SMSContract;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;

class KaveNegarService implements SMSContract
{
    const KAVE_NEGAR_QUEUE = 'kave-negar';

    const SEND_SINGLE_MESSAGE = 'send';
    const CHECK_MESSAE_STATUS = 'status';

    /**
     * @var PendingRequest
     */
    private $request;

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $apiKey;

    /**
     * @var array
     */
    private array $urls;

    /**
     * KaveNegarService constructor.
     *
     * @param array $kaveNegarConfig
     * @param PendingRequest $request
     */
    public function __construct(array $kaveNegarConfig, PendingRequest $request)
    {
        $this->request = $request;
        $this->apiKey = $kaveNegarConfig['api-key'];
        $this->prepareUrls($kaveNegarConfig['endpoints']['v1']);

    }

    /**
     * @param string $message
     * @param array $receptors
     * @param array $options
     *
     * @return mixed|void
     */
    public function sendAsyncMessage(string $message, array $receptors, array $options = [])
    {
        $data = prepareBodyRequest($message, $receptors, $options);
        KaveNegarJob::dispatch('GET', $this->urls[self::SEND_SINGLE_MESSAGE], $data)->onQueue(self::KAVE_NEGAR_QUEUE);
    }

    /**
     * @param string $message
     * @param array $receptors
     * @param array $options
     *
     * @return mixed|void
     */
    public function sendSyncMessage(string $message, array $receptors, array $options = [])
    {
        $data = prepareBodyRequest($message, $receptors, $options);
        $response = $this->request->get($this->urls[self::SEND_SINGLE_MESSAGE], $data)->onError(function () {

        });
        return $response->json();
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

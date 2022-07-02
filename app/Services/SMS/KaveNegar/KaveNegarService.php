<?php

namespace App\Services\SMS\KaveNegar;

use App\Exceptions\KaveNegarException;
use App\Jobs\SMS\KaveNegarJob;
use App\Services\SMS\SMSContract;
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
     * @param array $kaveNegarConfig
     * @param PendingRequest $request
     */
    public function __construct(private array $kaveNegarConfig, private PendingRequest $request)
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
        KaveNegarJob::dispatch('get', $this->urls[self::SEND_SINGLE_MESSAGE], $data);
    }

    /**
     * @param string $message
     * @param array $receptors
     * @param array $options
     *
     * @return mixed
     */
    public function sendSyncMessage(string $message, array $receptors, array $options = [])
    {
        $data = prepareBodyRequest($message, $receptors, $options);
        $response = $this->request->get($this->urls[self::SEND_SINGLE_MESSAGE], $data)->onError(function ($error) {
            throw new KaveNegarException($error->json(), $error->status());
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

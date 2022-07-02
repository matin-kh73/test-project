<?php

namespace App\Services\SMS;

use App\Services\SMS\KaveNegar\KaveNegarService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Manager;

class SMSManager extends Manager
{
    /**
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'kave-negar';
    }

    /**
     * @return KaveNegarService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createKaveNegarDriver()
    {
        return new KaveNegarService(config('sms.drivers.kave-negar'), app()->make(PendingRequest::class));
    }
}

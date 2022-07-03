<?php

namespace App\Drivers\SMS;

use App\Services\SMS\KaveNegar\KaveNegarService;
use Illuminate\Contracts\Container\BindingResolutionException;
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
     * @throws BindingResolutionException
     */
    public function createKaveNegarDriver()
    {
        return new KaveNegarService(app()->make(PendingRequest::class), config('sms.drivers.kave-negar'));
    }
}

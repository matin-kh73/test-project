<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method \App\Services\SMS\SMSContract sendAsyncMessage(string $message, array $receptors, array $options = [])
 * @method \App\Services\SMS\SMSContract sendSyncMessage(string $message, array $receptors, array $options = [])

 * @method static \Illuminate\Support\Manager driver($driver = null)
 *
 * @see \App\Services\SMS\SMSManager
 */
class SMSManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sms-manager';
    }
}

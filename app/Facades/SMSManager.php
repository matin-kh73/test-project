<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Drivers\SMS\SMSManager driver(string $driver)
 */
class SMSManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'sms-manager';
    }
}

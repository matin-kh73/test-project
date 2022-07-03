<?php

namespace App\Drivers\SMS;

use Carbon\Carbon;
use Illuminate\Http\Client\Response;

interface SMSContract
{
    /**
     * @param string $message
     * @param array $receptors
     * @param string $sender
     * @param Carbon|null $date
     *
     * @return array
     */
    public function sendAsyncMessage(string $message, array $receptors, string $sender = '', Carbon $date = null): array;

    /**
     * @param string $message
     * @param array $receptors
     * @param string $sender
     * @param Carbon|null $date
     *
     * @return array
     */
    public function sendSyncMessage(string $message, array $receptors, string $sender = '', Carbon $date = null): array;
}

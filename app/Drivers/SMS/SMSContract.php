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
     * @return void
     */
    public function sendAsyncMessage(string $message, array $receptors, string $sender = '', Carbon $date = null): void;

    /**
     * @param string $message
     * @param array $receptors
     * @param string $sender
     * @param Carbon|null $date
     *
     * @return Response
     */
    public function sendSyncMessage(string $message, array $receptors, string $sender = '', Carbon $date = null): Response;
}

<?php

namespace App\Drivers\SMS;

use Carbon\Carbon;
use Illuminate\Http\Client\Response;

interface SMSContract
{
    /**
     * @param string $message
     * @param string $sender
     * @param array $receptors
     * @param Carbon $date
     *
     * @return void
     */
    public function sendAsyncMessage(string $message, string $sender, array $receptors, Carbon $date = null): void;

    /**
     * @param string $message
     * @param string $sender
     * @param array $receptors
     * @param Carbon|null $date
     *
     * @return Response
     */
    public function sendSyncMessage(string $message, string $sender, array $receptors, Carbon $date = null): Response;
}

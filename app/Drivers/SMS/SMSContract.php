<?php

namespace App\Services\SMS;

interface SMSContract
{
    /**
     * @param string $message
     * @param array $receptors
     * @param array $options
     *
     * @return mixed
     */
    public function sendAsyncMessage(string $message, array $receptors, array $options = []);

    /**
     * @param string $message
     * @param array $receptors
     * @param array $options
     * @return mixed
     */
    public function sendSyncMessage(string $message, array $receptors, array $options = []);
}

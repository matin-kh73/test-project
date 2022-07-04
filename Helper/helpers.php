<?php

if (!function_exists('prepareBodyRequest')) {

    /**
     * @param string $message
     * @param string $sender
     * @param array $receptors
     *
     * @return array
     */
    function prepareBodyRequest(array $receptors, string $message, string $sender)
    {
        return [
            'receptor' => implode(',', $receptors),
            'message' => $message,
            'sender' => $sender ?: config('sms.drivers.kave-negar.sender')
        ];
    }
}

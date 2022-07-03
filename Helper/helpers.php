<?php

use Carbon\Carbon;

if (!function_exists('prepareBodyRequest')) {

    /**
     * @param string $message
     * @param string $sender
     * @param array $receptors
     * @param Carbon $date|null
     *
     * @return array
     */
    function prepareBodyRequest(array $receptors, string $message, string $sender, Carbon $date = null)
    {
        $data = [];
        if ($date) {
            $data['date'] = $date;
        }
        $data = [
            'receptor' => implode(',', $receptors),
            'message' => $message,
            'sender' => $sender ?? config('sms.drivers.kave-negar.sender')
        ];
        return $data;
    }
}

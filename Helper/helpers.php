<?php

if (!function_exists('prepareBodyRequest')) {

    /**
     * @param string $message
     * @param array $receptors
     * @param array $options
     *
     * @return array
     */
    function prepareBodyRequest(string $message, array $receptors, array $options = [])
    {
        return [
            'receptor' => implode(',', $receptors),
            'message' => $message,
            'date' => $options['date'] ?? now()->unix(),
            'sender' => $options['sender'] ?? ''
        ];
    }
}

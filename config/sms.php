<?php
return [
    'drivers' => [
        'default' => 'kave-negar',
        'kave-negar' => [
            'api-key' => env('SMS_API_KEY'),
            'sender' => env('SMS_SENDER'),
            'endpoints' => [
                'v1' => [
                    'send' => "https://api.kavenegar.com/v1/{api-key}/sms/send.json",
                    'status' => 'https://api.kavenegar.com/v1/{api-key}/sms/status.json'
                ]
            ]
        ],
        'ghasedak' => [
            'api-key' => '',
            'sender' => '',
        ]
    ]
];

<?php
return [

    'drivers' => [
        'kave-negar' => [
            'api-key' => '337A3567577644367234516C4E514B6454716C4B706F4442526B5835522B7859743731356A374E62786A6B3D',
            'sender' => '',
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

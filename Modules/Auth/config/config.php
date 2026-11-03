<?php

return [
    'name' => 'Auth',

    'sms' => [
        'base_url' => env('SMS_BASE_URL', 'https://edge.ippanel.com/v1'),
        'token' => env('SMS_TOKEN'),
        'from' => env('SMS_FROM'),
    ],
];

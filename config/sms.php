<?php

return [
    'patterns' => [
        'otp' => env('SMS_PATTERN_OTP'),
        'otp_forgot_password' => env('SMS_PATTERN_OTP_FORGOT_PASSWORD', env('SMS_PATTERN_OTP')),
        'password_changed' => env('SMS_PATTERN_PASSWORD_CHANGED'),
    ],
];

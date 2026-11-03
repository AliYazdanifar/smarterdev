<?php

namespace App\Support\Sms;

enum SmsScenario: string
{
    case AuthOtpLogin = 'auth_otp_login';
    case AuthOtpForgotPassword = 'auth_otp_forgot_password';
    case AuthPasswordChanged = 'auth_password_changed';

    public function patternConfigKey(): string
    {
        return match ($this) {
            self::AuthOtpLogin => 'otp',
            self::AuthOtpForgotPassword => 'otp_forgot_password',
            self::AuthPasswordChanged => 'password_changed',
        };
    }
}

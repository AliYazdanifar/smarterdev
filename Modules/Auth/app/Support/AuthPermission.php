<?php

namespace Modules\Auth\Support;

class AuthPermission
{
    public const OTP_CODES_VIEW = 'otp_codes.view';

    /**
     * @return array<int, string>
     */
    public static function all(): array
    {
        return [
            self::OTP_CODES_VIEW,
        ];
    }
}

<?php

namespace Modules\Auth\Exceptions;

use Exception;
use Modules\Auth\Models\OtpCode;

class OtpAlreadySentException extends Exception
{
    public function __construct(
        public readonly OtpCode $otp,
        string $message = 'کد تایید قبلاً ارسال شده است. لطفاً تا پایان اعتبار کد قبلی صبر کنید.'
    ) {
        parent::__construct($message);
    }

    public function toArray(): array
    {
        return [
            'expires_at' => $this->otp->expires_at->toIso8601String(),
            'remaining_seconds' => $this->remainingSeconds(),
        ];
    }

    public function remainingSeconds(): int
    {
        if ($this->otp->expires_at->isPast()) {
            return 0;
        }

        return (int) now()->diffInSeconds($this->otp->expires_at);
    }
}

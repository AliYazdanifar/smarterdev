<?php

namespace Modules\Auth\Services;

use App\Exceptions\SmsSendFailedException;
use App\Services\SmsService;
use App\Support\Sms\SmsScenario;
use Modules\Auth\Exceptions\InvalidOtpException;
use Modules\Auth\Exceptions\OtpAlreadySentException;
use Modules\Auth\Models\OtpCode;

class OtpService
{
    private const OTP_LENGTH = 4;

    private const OTP_EXPIRY_MINUTES = 5;

    public function __construct(
        private readonly SmsService $smsService
    ) {}

    public function generateAndSend(
        string $receiver,
        string $receiverType = 'sms',
        SmsScenario $scenario = SmsScenario::AuthOtpLogin,
    ): OtpCode
    {
        $existing = $this->findActiveOtp($receiver, $receiverType);

        if ($existing) {
            throw new OtpAlreadySentException($existing);
        }

        $code = $this->generateCode();

        $otp = OtpCode::create([
            'receiver' => $receiver,
            'receiver_type' => $receiverType,
            'code' => $code,
            'expires_at' => now()->addMinutes(self::OTP_EXPIRY_MINUTES),
        ]);

        if ($receiverType === 'sms') {
            try {
                $this->smsService->sendOtp($receiver, $code, $scenario);
            } catch (SmsSendFailedException $e) {
                $otp->delete();

                throw $e;
            }
        }

        return $otp;
    }

    public function verify(string $receiver, string $code, string $receiverType = 'sms'): void
    {
        $otp = OtpCode::query()
            ->where('receiver', $receiver)
            ->where('receiver_type', $receiverType)
            ->where('code', $code)
            ->valid()
            ->latest()
            ->first();

        if (! $otp) {
            throw new InvalidOtpException;
        }

        $otp->update(['used_at' => now()]);
    }

    public function findActiveOtp(string $receiver, string $receiverType = 'sms'): ?OtpCode
    {
        return OtpCode::query()
            ->where('receiver', $receiver)
            ->where('receiver_type', $receiverType)
            ->valid()
            ->latest()
            ->first();
    }

    private function generateCode(): string
    {
        return str_pad((string) random_int(0, 9999), self::OTP_LENGTH, '0', STR_PAD_LEFT);
    }
}

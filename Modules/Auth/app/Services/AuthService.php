<?php

namespace Modules\Auth\Services;

use App\Services\SmsService;
use App\Support\Sms\SmsScenario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Exceptions\OtpAlreadySentException;
use Modules\Auth\Exceptions\PhoneNotVerifiedException;
use Modules\User\Events\UserAuthenticated;
use Modules\User\Models\User;
use Modules\Reporting\Services\AudienceAttributionRecorder;
use Modules\User\Services\UserImpersonationService;
use Modules\User\Services\UserService;
use Modules\User\Support\UserImpersonation;

class AuthService
{
    public function __construct(
        private readonly OtpService $otpService,
        private readonly UserService $userService,
        private readonly UserImpersonationService $userImpersonationService,
        private readonly SmsService $smsService,
        private readonly AudienceAttributionRecorder $audienceAttributionRecorder,
    ) {}

    /**
     * @throws OtpAlreadySentException
     */
    public function register(array $data): User
    {
        $user = $this->userService->create([
            'first_name' => $data['first_name'],
            'lastname' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'password' => $data['password'],
            'roles' => [User::ROLE_STUDENT],
        ]);

        $this->audienceAttributionRecorder->recordFirstTouchForUser($user, [
            'acquisition_channel' => $data['acquisition_channel'] ?? null,
            'acquisition_campaign' => $data['acquisition_campaign'] ?? null,
            'utm_source' => $data['utm_source'] ?? null,
            'utm_campaign' => $data['utm_campaign'] ?? null,
        ]);

        $this->otpService->generateAndSend($user->phone);

        return $user;
    }

    public function verifyOtp(string $phone, string $code): array
    {
        $user = User::where('phone', $phone)->firstOrFail();

        $this->otpService->verify($phone, $code);

        if (! $user->isPhoneVerified()) {
            $user->update(['phone_verified_at' => now()]);
        }

        $response = $this->createAuthResponse($user);

        UserAuthenticated::dispatch($user);

        return $response;
    }

    public function resendOtp(string $phone): void
    {
        $user = User::where('phone', $phone)->firstOrFail();

        $this->otpService->generateAndSend($user->phone);
    }

    public function login(string $phone, string $password): array
    {
        $user = User::where('phone', $phone)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['اطلاعات ورود نادرست است.'],
            ]);
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'phone' => ['حساب کاربری شما غیرفعال است.'],
            ]);
        }

        if (! $user->isPhoneVerified()) {
            $this->otpService->generateAndSend($user->phone);

            throw new PhoneNotVerifiedException(
                'شماره همراه تایید نشده است. کد تایید برای شما ارسال شد.'
            );
        }

        $response = $this->createAuthResponse($user);

        UserAuthenticated::dispatch($user);

        return $response;
    }

    public function forgotPassword(string $phone): void
    {
        $user = $this->findActiveUserByPhone($phone);

        $this->otpService->generateAndSend($user->phone, 'sms', SmsScenario::AuthOtpForgotPassword);
    }

    public function resetPassword(string $phone, string $code, string $password): void
    {
        $user = $this->findActiveUserByPhone($phone);

        $this->otpService->verify($phone, $code);

        $updates = ['password' => $password];

        if (! $user->isPhoneVerified()) {
            $updates['phone_verified_at'] = now();
        }

        $user->update($updates);
        $user->tokens()->delete();

        $this->smsService->sendScenario(SmsScenario::AuthPasswordChanged, $phone, []);
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }

    public function consumeImpersonation(string $plainToken): array
    {
        $user = $this->userImpersonationService->consume($plainToken);

        return $this->createAuthResponse(
            $user,
            UserImpersonation::SANCTUM_TOKEN_NAME,
            now()->addHours($this->userImpersonationService->sessionTtlHours()),
            isImpersonating: true,
        );
    }

    private function findActiveUserByPhone(string $phone): User
    {
        $user = User::where('phone', $phone)->firstOrFail();

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'phone' => ['حساب کاربری شما غیرفعال است.'],
            ]);
        }

        return $user;
    }

    private function createAuthResponse(
        User $user,
        string $tokenName = 'auth-token',
        ?\DateTimeInterface $expiresAt = null,
        bool $isImpersonating = false,
    ): array {
        $token = $user->createToken($tokenName, ['*'], $expiresAt)->plainTextToken;

        $user->loadMissing(['character', 'level', 'media']);

        return [
            'user' => $user,
            'token' => $token,
            'is_impersonating' => $isImpersonating,
        ];
    }
}

<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Auth\Exceptions\InvalidOtpException;
use Modules\Auth\Exceptions\OtpAlreadySentException;
use Modules\Auth\Exceptions\PhoneNotVerifiedException;
use Modules\Auth\Http\Requests\ForgotPasswordRequest;
use Modules\Auth\Http\Requests\ImpersonateRequest;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\ResendOtpRequest;
use Modules\Auth\Http\Requests\ResetPasswordRequest;
use Modules\Auth\Http\Requests\VerifyOtpRequest;
use Modules\Auth\Http\Resources\AuthTokenResource;
use Modules\Auth\Http\Resources\AuthUserResource;
use Modules\Auth\Services\AuthService;
use Modules\User\Exceptions\InvalidImpersonationTokenException;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $this->authService->register($request->validated());
        } catch (OtpAlreadySentException $e) {
            return $this->otpAlreadySentResponse($e);
        }

        return ApiResponse::success(
            null,
            'ثبت‌نام با موفقیت انجام شد. کد تایید برای شما ارسال شد.',
            201
        );
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->verifyOtp(
                $request->validated('phone'),
                $request->validated('code')
            );
        } catch (InvalidOtpException $e) {
            return ApiResponse::error($e->getMessage(), null, 422);
        }

        return ApiResponse::success(
            new AuthTokenResource($result),
            'شماره همراه با موفقیت تایید شد.'
        );
    }

    public function resendOtp(ResendOtpRequest $request): JsonResponse
    {
        try {
            $this->authService->resendOtp($request->validated('phone'));
        } catch (OtpAlreadySentException $e) {
            return $this->otpAlreadySentResponse($e);
        }

        return ApiResponse::success(
            null,
            'کد تایید مجدداً ارسال شد.'
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login(
                $request->validated('phone'),
                $request->validated('password')
            );
        } catch (PhoneNotVerifiedException $e) {
            return ApiResponse::error($e->getMessage(), [
                'needs_verification' => true,
            ], 403);
        } catch (OtpAlreadySentException $e) {
            return $this->otpAlreadySentResponse($e, [
                'needs_verification' => true,
            ]);
        }

        return ApiResponse::success(
            new AuthTokenResource($result),
            'ورود با موفقیت انجام شد.'
        );
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $this->authService->forgotPassword($request->validated('phone'));
        } catch (OtpAlreadySentException $e) {
            return $this->otpAlreadySentResponse($e);
        }

        return ApiResponse::success(
            null,
            'کد تایید برای بازیابی رمز عبور ارسال شد.'
        );
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $this->authService->resetPassword(
                $request->validated('phone'),
                $request->validated('code'),
                $request->validated('password')
            );
        } catch (InvalidOtpException $e) {
            return ApiResponse::error($e->getMessage(), null, 422);
        }

        return ApiResponse::success(
            null,
            'رمز عبور با موفقیت تغییر کرد. اکنون می‌توانید وارد شوید.'
        );
    }

    public function impersonate(ImpersonateRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->consumeImpersonation(
                $request->validated('token')
            );
        } catch (InvalidImpersonationTokenException $e) {
            return ApiResponse::error($e->getMessage(), null, 422);
        }

        return ApiResponse::success(
            new AuthTokenResource($result),
            'ورود به نمایه کاربر با موفقیت انجام شد.'
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return ApiResponse::success(null, 'خروج با موفقیت انجام شد.');
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load(['character', 'level', 'media']);

        return ApiResponse::success(
            (new AuthUserResource($user))->impersonating($user->isImpersonating())
        );
    }

    private function otpAlreadySentResponse(OtpAlreadySentException $e, ?array $errors = null): JsonResponse
    {
        return ApiResponse::error(
            $e->getMessage(),
            $errors,
            429,
            $e->toArray()
        );
    }
}

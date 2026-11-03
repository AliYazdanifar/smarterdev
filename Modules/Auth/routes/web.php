<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Admin\OtpCodeController;
use Modules\Auth\Support\AuthPermission;

Route::prefix('admin-panel')
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function () {
        Route::get('otp-codes', [OtpCodeController::class, 'index'])
            ->middleware('admin.permission:'.AuthPermission::OTP_CODES_VIEW)
            ->name('otp-codes.index');
    });

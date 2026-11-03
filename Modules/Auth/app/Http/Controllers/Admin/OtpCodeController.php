<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Modules\Auth\Http\Requests\Admin\IndexOtpCodeRequest;
use Modules\Auth\Services\OtpCodeAdminService;

class OtpCodeController extends Controller
{
    public function __construct(
        private readonly OtpCodeAdminService $otpCodeAdminService,
    ) {}

    public function index(IndexOtpCodeRequest $request): View
    {
        return view('auth::admin.otp-codes.index', [
            'otpCodes' => $this->otpCodeAdminService->paginate(
                $request->filters(),
                $request->integer('per_page', 15),
            ),
        ]);
    }
}

@extends('layouts.admin.master')

@section('title', 'کدهای OTP')

@section('content')
    <div class="card">
        <div class="card-header card-no-border">
            <h5 class="mb-0">کدهای OTP</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.otp-codes.index') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="جستجو شماره یا کد..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="receiver_type" class="form-select">
                        <option value="">همه انواع</option>
                        <option value="sms" @selected(request('receiver_type') === 'sms')>پیامک</option>
                        <option value="email" @selected(request('receiver_type') === 'email')>ایمیل</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="active" @selected(request('status') === 'active')>معتبر</option>
                        <option value="used" @selected(request('status') === 'used')>استفاده‌شده</option>
                        <option value="expired" @selected(request('status') === 'expired')>منقضی</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="per_page" class="form-select">
                        @foreach ([10, 15, 25, 50] as $size)
                            <option value="{{ $size }}" @selected(request('per_page', 15) == $size)>{{ $size }} مورد</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">جستجو</button>
                    <a href="{{ route('admin.otp-codes.index') }}" class="btn btn-light">پاک کردن</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>گیرنده</th>
                            <th>نوع</th>
                            <th>کد</th>
                            <th>وضعیت</th>
                            <th>انقضا</th>
                            <th>استفاده</th>
                            <th>ایجاد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($otpCodes as $otp)
                            <tr>
                                <td>{{ $otp->id }}</td>
                                <td>{{ $otp->receiver }}</td>
                                <td>
                                    <span class="badge {{ $otp->receiver_type === 'sms' ? 'badge-light-primary' : 'badge-light-info' }}">
                                        {{ $otp->receiver_type === 'sms' ? 'پیامک' : 'ایمیل' }}
                                    </span>
                                </td>
                                <td class="fw-bold font-primary">{{ $otp->code }}</td>
                                <td>
                                    @if ($otp->isUsed())
                                        <span class="badge badge-light-secondary">استفاده‌شده</span>
                                    @elseif ($otp->isExpired())
                                        <span class="badge badge-light-danger">منقضی</span>
                                    @else
                                        <span class="badge badge-light-success">معتبر</span>
                                    @endif
                                </td>
                                <td>{{ \App\Support\JalaliDate::format($otp->expires_at, 'Y/m/d H:i') }}</td>
                                <td>{{ \App\Support\JalaliDate::format($otp->used_at, 'Y/m/d H:i') }}</td>
                                <td>{{ \App\Support\JalaliDate::format($otp->created_at, 'Y/m/d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">کد OTP یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($otpCodes->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $otpCodes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

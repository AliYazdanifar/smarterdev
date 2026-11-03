@extends('layouts.shop.master')

@section('content')
@php
    $req = '<span class="req" aria-hidden="true">*</span><span class="visually-hidden">(الزامی)</span>';
    $next = request('next');
@endphp
<main id="main">
  <div class="wiz-shell"><div class="container"><div class="auth-wrap" data-auth-root>
    <div class="wiz-card">
      <h1>ورود به حساب کاربری</h1>
      <p>برای ثبت و پیگیری درخواست پروژه، با شماره موبایل و گذرواژه وارد شوید.</p>

      <div class="notice notice--info my-4" data-auth-alert hidden role="alert">
        <i class="bi bi-info-circle" aria-hidden="true"></i><p></p>
      </div>

      <div data-auth-step="credentials">
        <form data-auth-login novalidate>
          <div class="sd-field">
            <label class="sd-label" for="a-phone">شماره موبایل {!! $req !!}</label>
            <input class="sd-input ltr" id="a-phone" name="phone" type="tel" dir="ltr" inputmode="tel" autocomplete="tel" required aria-describedby="a-phone-error">
            <p class="field-error" id="a-phone-error" hidden></p>
          </div>
          <div class="sd-field">
            <label class="sd-label" for="a-pass">گذرواژه {!! $req !!}</label>
            <input class="sd-input ltr" id="a-pass" name="password" type="password" dir="ltr" autocomplete="current-password" required aria-describedby="a-pass-error">
            <p class="field-error" id="a-pass-error" hidden></p>
          </div>
          <button class="btn-sd btn-sd--primary btn-sd--block" type="submit">ورود <i class="bi bi-box-arrow-in-left" aria-hidden="true"></i></button>
        </form>
        <p class="auth-alt">حساب ندارید؟ <a href="{{ route('register', array_filter(['next' => $next])) }}">ایجاد حساب کاربری</a></p>
      </div>

      <div data-auth-step="otp" hidden>
        <h2 class="h4">تایید شماره موبایل</h2>
        <p>کد ۴ رقمی ارسال‌شده به <strong dir="ltr" data-otp-phone></strong> را وارد کنید.</p>
        <form novalidate>
          <div class="sd-field">
            <label class="sd-label" for="a-otp">کد تایید {!! $req !!}</label>
            <input class="sd-input ltr" id="a-otp" name="code" type="text" dir="ltr" inputmode="numeric" autocomplete="one-time-code" maxlength="4" pattern="\d{4}" required aria-describedby="a-otp-error">
            <p class="field-error" id="a-otp-error" hidden></p>
          </div>
          <button class="btn-sd btn-sd--primary btn-sd--block" type="submit">تایید و ورود</button>
        </form>
        <p class="auth-alt mt-3"><button type="button" class="btn-sd btn-sd--ghost btn-sd--sm" data-resend-otp>ارسال مجدد کد</button></p>
      </div>
    </div>
  </div></div></div>
</main>
@endsection

@push('scripts')
<script>window.SD_AUTH={apiBase:@json(url('/api/v1/auth')),projectRequestUrl:@json(route('project-request'))};</script>
<script src="{{ asset('assets/js/auth.js') }}" defer></script>
<script src="{{ asset('assets/js/auth-forms.js') }}" defer></script>
@endpush

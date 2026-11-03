@extends('layouts.shop.master')

@section('content')
@php
    $req = '<span class="req" aria-hidden="true">*</span><span class="visually-hidden">(الزامی)</span>';
    $next = request('next');
@endphp
<main id="main">
  <div class="wiz-shell"><div class="container"><div class="auth-wrap" data-auth-root>
    <div class="wiz-card">
      <h1>ایجاد حساب کاربری</h1>
      <p>با یک حساب کاربری می‌توانید درخواست‌های خود را ثبت و پیگیری کنید. پس از ثبت‌نام، یک‌بار کد تایید برای شماره موبایل ارسال می‌شود.</p>

      <div class="notice notice--info my-4" data-auth-alert hidden role="alert">
        <i class="bi bi-info-circle" aria-hidden="true"></i><p></p>
      </div>

      <div data-auth-step="credentials">
        <form data-auth-register novalidate>
          <div class="sd-field">
            <label class="sd-label" for="r-name">نام و نام خانوادگی {!! $req !!}</label>
            <input class="sd-input" id="r-name" name="name" type="text" autocomplete="name" required aria-describedby="r-name-error">
            <p class="field-error" id="r-name-error" hidden></p>
          </div>
          <div class="sd-field">
            <label class="sd-label" for="r-phone">شماره موبایل {!! $req !!}</label>
            <input class="sd-input ltr" id="r-phone" name="phone" type="tel" dir="ltr" inputmode="tel" autocomplete="tel" required aria-describedby="r-phone-error">
            <p class="field-error" id="r-phone-error" hidden></p>
          </div>
          <div class="sd-field">
            <label class="sd-label" for="r-pass">گذرواژه {!! $req !!}</label>
            <input class="sd-input ltr" id="r-pass" name="password" type="password" dir="ltr" autocomplete="new-password" required data-min="8" aria-describedby="r-pass-hint r-pass-error">
            <p class="sd-hint" id="r-pass-hint">حداقل ۸ نویسه.</p>
            <p class="field-error" id="r-pass-error" hidden></p>
          </div>
          <div class="sd-field">
            <label class="sd-label" for="r-pass2">تکرار گذرواژه {!! $req !!}</label>
            <input class="sd-input ltr" id="r-pass2" name="password_confirmation" type="password" dir="ltr" autocomplete="new-password" required aria-describedby="r-pass2-error">
            <p class="field-error" id="r-pass2-error" hidden></p>
          </div>
          <div class="sd-field">
            <label class="sd-check" for="r-consent">
              <input type="checkbox" id="r-consent" aria-describedby="r-consent-error">
              <span>با <a href="{{ route('privacy') }}" target="_blank" rel="noopener">سیاست حریم خصوصی</a> موافقم. {!! $req !!}</span>
            </label>
            <p class="field-error" id="r-consent-error" hidden></p>
          </div>
          <button class="btn-sd btn-sd--primary btn-sd--block" type="submit">ایجاد حساب <i class="bi bi-person-plus" aria-hidden="true"></i></button>
        </form>
        <p class="auth-alt">حساب دارید؟ <a href="{{ route('login', array_filter(['next' => $next])) }}">ورود</a></p>
      </div>

      <div data-auth-step="otp" hidden>
        <h2 class="h4">تایید شماره موبایل</h2>
        <p>کد ۴ رقمی ارسال‌شده به <strong dir="ltr" data-otp-phone></strong> را وارد کنید.</p>
        <form novalidate>
          <div class="sd-field">
            <label class="sd-label" for="r-otp">کد تایید {!! $req !!}</label>
            <input class="sd-input ltr" id="r-otp" name="code" type="text" dir="ltr" inputmode="numeric" autocomplete="one-time-code" maxlength="4" pattern="\d{4}" required aria-describedby="r-otp-error">
            <p class="field-error" id="r-otp-error" hidden></p>
          </div>
          <button class="btn-sd btn-sd--primary btn-sd--block" type="submit">تایید و ادامه</button>
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

@extends('layouts.shop.master')

@section('content')
@php $req = '<span class="req" aria-hidden="true">*</span><span class="visually-hidden">(الزامی)</span>'; @endphp
<main id="main">
  <div class="wiz-shell"><div class="container"><div class="auth-wrap">
    <div class="wiz-card">
      <h1>ورود به حساب کاربری</h1>
      <p>برای ثبت و پیگیری درخواست پروژه وارد شوید.</p>
      <div class="notice my-4"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><p><strong>نسخهٔ نمایشی:</strong> این صفحه ورود یا حساب واقعی ایجاد نمی‌کند. فقط ظاهر و اعتبارسنجی فرم را نشان می‌دهد.</p></div>
      <form action="#" method="post" novalidate data-demo-form>
        <div class="sd-field"><label class="sd-label" for="a-id">ایمیل یا شماره موبایل {!! $req !!}</label>
          <input class="sd-input ltr" id="a-id" name="identifier" type="text" dir="ltr" autocomplete="username" required data-kind="contact" aria-describedby="a-id-error"><p class="field-error" id="a-id-error" hidden></p></div>
        <div class="sd-field"><label class="sd-label" for="a-pass">گذرواژه {!! $req !!}</label>
          <input class="sd-input ltr" id="a-pass" name="password" type="password" dir="ltr" autocomplete="current-password" required aria-describedby="a-pass-error"><p class="field-error" id="a-pass-error" hidden></p></div>
        <button class="btn-sd btn-sd--primary btn-sd--block" type="submit">ورود <i class="bi bi-box-arrow-in-left" aria-hidden="true"></i></button>
      </form>
      <div class="demo-success notice notice--info" data-demo-success hidden role="status">
        <i class="bi bi-info-circle" aria-hidden="true"></i>
        <div><p tabindex="-1" data-focus-target><strong>اعتبارسنجی موفق بود؛ ورود واقعی انجام نشد.</strong></p>
          <a class="btn-sd btn-sd--primary btn-sd--sm mt-2" href="{{ route('project-request', ['entry' => 'demo']) }}">ادامه به ثبت درخواست (نمایشی)</a></div>
      </div>
      <p class="auth-alt">حساب ندارید؟ <a href="{{ route('register') }}">ایجاد حساب کاربری</a></p>
    </div>
  </div></div></div>
</main>
@endsection

@extends('layouts.shop.master')

@section('content')
@php
    $c = site('contact');
    $req = '<span class="req" aria-hidden="true">*</span><span class="visually-hidden">(الزامی)</span>';
@endphp
@include('layouts.shop.partials.page-hero', [
    'page' => $page,
    'eyebrow' => 'تماس',
    'h1' => 'با ما در تماس باشید',
    'lead' => 'برای پرسش‌های کلی می‌توانید پیام بگذارید. اگر پروژه یا مشکل مشخصی دارید، ثبت درخواست پروژه سریع‌ترین مسیر برای بررسی دقیق است.',
    'actions' => [['ثبت درخواست پروژه', route('project-request')]],
])
<main id="main">
  <section class="section"><div class="container">
    <div class="row g-4 g-lg-5">
      <div class="col-12 col-lg-5"><h2 class="visually-hidden">اطلاعات تماس</h2><div class="d-grid gap-3">
        <div class="contact-item"><span class="icon-tile icon-tile--cyan" aria-hidden="true"><i class="bi bi-envelope"></i></span>
          <div><h3>ایمیل</h3>
            @if (! empty($c['email']))<a class="ltr" href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a>@else<p class="is-placeholder">به‌زودی اضافه می‌شود</p>@endif
          </div></div>
        <div class="contact-item"><span class="icon-tile icon-tile--cyan" aria-hidden="true"><i class="bi bi-telephone"></i></span>
          <div><h3>تلفن</h3>
            @if (! empty($c['phone']))<a href="tel:{{ $c['phone'] }}">{{ $c['phone'] }}</a>@else<p class="is-placeholder">به‌زودی اضافه می‌شود</p>@endif
          </div></div>
        <div class="contact-item"><span class="icon-tile icon-tile--cyan" aria-hidden="true"><i class="bi bi-send"></i></span>
          <div><h3>پیام‌رسان</h3>
            @if (! empty($c['telegram']))<a href="{{ $c['telegram'] }}" rel="noopener" target="_blank">ارسال پیام</a>@else<p class="is-placeholder">به‌زودی اضافه می‌شود</p>@endif
          </div></div>
        <div class="contact-item"><span class="icon-tile icon-tile--cyan" aria-hidden="true"><i class="bi bi-clock"></i></span>
          <div><h3>ساعات پاسخ‌گویی</h3>
            @if (! empty($c['hours']))<p>{{ $c['hours'] }}</p>@else<p class="is-placeholder">به‌زودی اضافه می‌شود</p>@endif
          </div></div>
        <div class="contact-item"><span class="icon-tile icon-tile--cyan" aria-hidden="true"><i class="bi bi-geo-alt"></i></span>
          <div><h3>نشانی</h3>
            @if (! empty($c['address']))<p>{{ $c['address'] }}</p>@else<p class="is-placeholder">به‌زودی اضافه می‌شود</p>@endif
          </div></div>
        <p class="sd-hint">اطلاعات تماس در <span class="mono">config/smarterdev.php</span> تنظیم می‌شود.</p>
      </div></div>

      <div class="col-12 col-lg-7">
        <div class="surface">
          <h2 class="h4 mb-3">ارسال پیام</h2>
          <div class="notice mb-4"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><p><strong>نسخهٔ نمایشی:</strong> این فرم فقط اعتبارسنجی می‌شود و پیامی ارسال نخواهد شد.</p></div>
          <form action="#" method="post" novalidate data-demo-form>
            <div class="sd-field"><label class="sd-label" for="c-name">نام {!! $req !!}</label>
              <input class="sd-input" id="c-name" name="name" type="text" autocomplete="name" required aria-describedby="c-name-error"><p class="field-error" id="c-name-error" hidden></p></div>
            <div class="sd-field"><label class="sd-label" for="c-contact">ایمیل یا شماره موبایل {!! $req !!}</label>
              <input class="sd-input ltr" id="c-contact" name="contact" type="text" dir="ltr" autocomplete="email" required data-kind="contact" aria-describedby="c-contact-error"><p class="field-error" id="c-contact-error" hidden></p></div>
            <div class="sd-field"><label class="sd-label" for="c-msg">پیام {!! $req !!}</label>
              <textarea class="sd-input" id="c-msg" name="message" rows="5" required data-min="10" aria-describedby="c-msg-error"></textarea><p class="field-error" id="c-msg-error" hidden></p></div>
            <button class="btn-sd btn-sd--primary" type="submit">ارسال پیام <i class="bi bi-arrow-left" aria-hidden="true"></i></button>
          </form>
          <div class="demo-success notice notice--info" data-demo-success hidden role="status">
            <i class="bi bi-info-circle" aria-hidden="true"></i>
            <p tabindex="-1" data-focus-target><strong>اعتبارسنجی موفق بود، اما این نسخهٔ نمایشی است.</strong> پیام شما ارسال یا ذخیره نشد.</p>
          </div>
        </div>
      </div>
    </div>
  </div></section>
</main>
@endsection

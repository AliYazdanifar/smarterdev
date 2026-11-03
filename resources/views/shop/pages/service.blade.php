@extends('layouts.shop.master')

@section('content')
<main id="main">

  <section class="page-hero dot-grid">
    <div class="container">
      @include('layouts.shop.partials.breadcrumb', ['page' => $page])
      <div class="svc-hero">
        <div>
          <span class="eyebrow">{{ $svc['title'] }}</span>
          <h1>{{ $svc['h1'] }}</h1>
          <p class="page-hero__lead">{{ $svc['lead'] }}</p>
          <div class="d-flex flex-wrap gap-3 mt-4">
            <a class="btn-sd btn-sd--primary" href="{{ $ctaUrl }}">ثبت درخواست برای این خدمت <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
            <a class="btn-sd btn-sd--ghost" href="{{ route('services') }}">سایر خدمات</a>
          </div>
        </div>
        <aside class="svc-aside" aria-labelledby="who-title">
          <span class="icon-tile" aria-hidden="true"><i class="bi {{ $svc['icon'] }}"></i></span>
          <h2 id="who-title">این خدمت برای چه کسانی است؟</h2>
          <ul class="check-list mt-3">
            @foreach ($svc['for_whom'] as $w)<li>{{ $w }}</li>@endforeach
          </ul>
        </aside>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="deliv-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">روش کار</span>
        <h2 id="deliv-title">در این خدمت چه چیزی دریافت می‌کنید؟</h2>
      </div>
      <div class="row g-3 g-lg-4">
        @foreach ($svc['deliverables'] as $n => $d)
          <div class="col-12 col-md-6 col-lg-3">
            <div class="deliv reveal" data-delay="{{ $n * 0.07 }}">
              <span class="deliv__n">{{ fa_num(str_pad((string) ($n + 1), 2, '0', STR_PAD_LEFT)) }}</span>
              <h3>{{ $d[0] }}</h3>
              <p>{{ $d[1] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section section--alt" aria-labelledby="scen-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">سناریوهای رایج</span>
        <h2 id="scen-title">نمونه‌هایی از مسائلی که با این خدمت حل می‌شوند</h2>
      </div>
      <div class="row g-3">
        @foreach ($svc['scenarios'] as $s)
          <div class="col-12 col-md-6"><div class="scenario reveal"><i class="bi bi-arrow-return-left" aria-hidden="true"></i><span>{{ $s }}</span></div></div>
        @endforeach
      </div>
      <div class="notice notice--info mt-4">
        <i class="bi bi-info-circle" aria-hidden="true"></i>
        <p>دامنه، زمان و هزینهٔ هر پروژه پس از بررسی فنی و توافق مشخص می‌شود. پیش از آن، نتیجه یا زمان‌بندی قطعی تضمین نمی‌شود.</p>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="proc-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">مسیر همکاری</span>
        <h2 id="proc-title">از درخواست تا اجرا چگونه پیش می‌رود؟</h2>
      </div>
      @include('layouts.shop.partials.process-steps')
    </div>
  </section>

  <section class="section section--alt" aria-labelledby="faq-title">
    <div class="container">
      <div class="row g-5">
        <div class="col-12 col-lg-4">
          <span class="eyebrow">پرسش‌های متداول</span>
          <h2 id="faq-title">دربارهٔ {{ $svc['title'] }}</h2>
        </div>
        <div class="col-12 col-lg-8">
          <div class="faq" data-faq>
            @foreach ($svc['faqs'] as $n => $faq)
              <x-shop.faq-item :faq="$faq" :id="$serviceKey.'-'.($n + 1)" />
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="rel-title">
    <div class="container">
      <h2 id="rel-title" class="h4 mb-4">خدمات مرتبط</h2>
      <div class="row g-3 mb-5">
        @foreach ($svc['related'] as $rk)
          <div class="col-12 col-md-4"><a class="related-link" href="{{ route($rk) }}"><span>{{ $all[$rk]['title'] }}</span><i class="bi bi-arrow-left" aria-hidden="true"></i></a></div>
        @endforeach
      </div>
      <x-shop.cta-band :title="'درخواست خود را برای «'.$svc['title'].'» ثبت کنید'" text="نیازتان را توضیح دهید تا مسیر مناسب برای اجرا یا بهبود آن را بررسی کنیم." label="ثبت درخواست پروژه" :href="$ctaUrl" />
    </div>
  </section>
</main>
@endsection

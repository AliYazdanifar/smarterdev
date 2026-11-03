@extends('layouts.shop.master')

@section('content')
@include('layouts.shop.partials.page-hero', [
    'page' => $page,
    'eyebrow' => 'درباره',
    'h1' => 'درباره SmarterDev',
    'lead' => 'SmarterDev یک کسب‌وکار شخصی در حوزهٔ مهندسی نرم‌افزار است؛ با تمرکز بر ساخت راهکارهایی که با فرایند واقعی شما هم‌خوان باشند، نه صرفاً کدی که تحویل داده می‌شود.',
])
<main id="main">
  @include('layouts.shop.partials.founder-section')

  <section class="section section--alt" aria-labelledby="principles-title">
    <div class="container">
      <div class="section-head"><span class="eyebrow">اصول کار</span><h2 id="principles-title">چطور کار می‌کنیم</h2></div>
      <div class="row g-3 g-lg-4">
        @foreach ([
          ['bi-chat-square-text', 'اول گفت‌وگو، بعد کدنویسی', 'پیش از هر پیشنهاد، مسئله، محدودیت‌ها و معیار موفقیت را روشن می‌کنیم.'],
          ['bi-signpost-split', 'شفافیت در دامنه و هزینه', 'آنچه انجام می‌شود، آنچه خارج از دامنه است و برآورد زمان و هزینه، پیش از شروع مکتوب می‌شود.'],
          ['bi-layers', 'ساده، قابل نگهداری، قابل توسعه', 'ترجیح ما راه‌حلی است که ادامه‌اش آسان باشد، نه پیچیده‌ترین راه‌حل ممکن.'],
          ['bi-robot', 'هوش مصنوعی در جای درست', 'هوش مصنوعی را جایی به کار می‌بریم که مسئله‌ای واقعی را بهتر حل کند، نه برای دنباله‌روی از روز.'],
        ] as $n => $p)
          <div class="col-12 col-md-6"><div class="why-item reveal" data-delay="{{ $n % 2 * 0.08 }}"><span class="icon-tile icon-tile--cyan" aria-hidden="true"><i class="bi {{ $p[0] }}"></i></span><div><h3>{{ $p[1] }}</h3><p>{{ $p[2] }}</p></div></div></div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section" aria-label="ثبت درخواست پروژه"><div class="container">
    <x-shop.cta-band title="درباره پروژه‌تان صحبت کنیم" text="نیازتان را توضیح دهید تا مسیر مناسب برای اجرا یا بهبود آن را بررسی کنیم." label="ثبت درخواست پروژه" :href="route('project-request')" :secondary="['تماس', route('contact')]" />
  </div></section>
</main>
@endsection

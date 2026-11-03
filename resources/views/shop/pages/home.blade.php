@extends('layouts.shop.master')

@section('content')
<main id="main">

  <!-- A. Hero -->
  <section class="hero" aria-labelledby="hero-title">
    <div class="container">
      <div class="hero__grid">
        <div>
          <span class="eyebrow">توسعه نرم‌افزار، هوش مصنوعی و اتوماسیون</span>
          <h1 id="hero-title">ایده‌های پیچیده را به <span class="gradient-text">راهکارهای نرم‌افزاری هوشمند</span> تبدیل می‌کنیم</h1>
          <p class="hero__lead">از توسعه نرم‌افزار اختصاصی و تعمیر پروژه‌های موجود تا ساخت ایجنت‌های هوش مصنوعی و اتوماسیون فرایندهای کسب‌وکار؛ راهکاری متناسب با نیاز واقعی شما طراحی و اجرا می‌کنیم.</p>
          <div class="hero__actions">
            <a class="btn-sd btn-sd--primary" href="{{ route('project-request') }}">شروع یک پروژه <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
            <a class="btn-sd btn-sd--ghost" href="{{ route('services') }}">مشاهده خدمات</a>
          </div>
          <div class="hero__trust">
            <i class="bi bi-patch-check" aria-hidden="true"></i>
            <span>بدون وعده‌های اغراق‌آمیز: هر پروژه ابتدا بررسی می‌شود و سپس دامنهٔ کار، زمان و هزینه به‌صورت شفاف با شما در میان گذاشته می‌شود.</span>
          </div>
          <ul class="list-unstyled d-flex flex-wrap gap-2 mt-4 mb-0" aria-label="مخاطبان">
            <li class="chip"><i class="bi bi-building" aria-hidden="true"></i>کسب‌وکارها</li>
            <li class="chip"><i class="bi bi-rocket-takeoff" aria-hidden="true"></i>استارتاپ‌ها</li>
            <li class="chip"><i class="bi bi-wrench-adjustable" aria-hidden="true"></i>صاحبان پروژه‌های موجود</li>
          </ul>
        </div>
        @include('layouts.shop.partials.hero-visual')
      </div>
    </div>
  </section>

  <!-- B. Services -->
  <section class="section section--alt" id="services" aria-labelledby="services-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">خدمات</span>
        <h2 id="services-title">از ایده تا اتوماسیون؛ نرم‌افزاری که کار می‌کند</h2>
        <p>هر خدمت حول یک نتیجهٔ کسب‌وکاری تعریف شده است: وقت کمتر برای کارهای تکراری، سیستم پایدارتر و محصولی که بتوان آن را توسعه داد.</p>
      </div>
      <div class="row g-4">
        @php $i = 0 @endphp
        @foreach ($services as $key => $svc)
          <div class="col-12 col-md-6 col-lg-4"><x-shop.service-card :key="$key" :svc="$svc" :delay="($i++ % 3) * 0.08" /></div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- C. AI agent spotlight -->
  <section class="section spotlight" id="ai-agents" aria-labelledby="agent-title">
    <div class="container position-relative">
      <div class="section-head">
        <span class="eyebrow">ایجنت هوش مصنوعی</span>
        <h2 id="agent-title">دستیاری که فقط پاسخ نمی‌دهد؛ کار را انجام می‌دهد</h2>
        <p>ایجنت هوش مصنوعی اطلاعات ورودی را می‌فهمد، از ابزارها و APIهای کسب‌وکار شما استفاده می‌کند و نتیجه را گزارش می‌دهد. نتیجه: کارهای تکراری کمتر و تصمیم‌گیری سریع‌تر برای تیم شما.</p>
      </div>

      <ol class="flow" aria-label="گردش‌کار یک ایجنت هوش مصنوعی">
        <li class="flow__node"><i class="bi bi-inbox" aria-hidden="true"></i><span>ورودی اطلاعات<small>پیام، سند، فرم یا رویداد</small></span></li>
        <li class="flow__node"><i class="bi bi-cpu" aria-hidden="true"></i><span>تحلیل هوشمند<small>فهم متن و تشخیص نیت</small></span></li>
        <li class="flow__node"><i class="bi bi-plug" aria-hidden="true"></i><span>ابزارها و APIها<small>CRM، پایگاه داده، ایمیل</small></span></li>
        <li class="flow__node"><i class="bi bi-play-circle" aria-hidden="true"></i><span>اجرای فرایند<small>ثبت، ارسال، به‌روزرسانی</small></span></li>
        <li class="flow__node"><i class="bi bi-file-earmark-bar-graph" aria-hidden="true"></i><span>گزارش نتیجه<small>خروجی شفاف و قابل پیگیری</small></span></li>
      </ol>

      <div class="row g-4 align-items-stretch">
        <div class="col-12 col-lg-7">
          <h3 class="h5 mb-3">نمونه کارهایی که یک ایجنت می‌تواند انجام دهد</h3>
          <div class="row g-3">
            @foreach ([              ['bi-signpost-split', 'دسته‌بندی و مسیریابی درخواست‌های مشتریان'],
              ['bi-file-earmark-text', 'استخراج اطلاعات از اسناد و فرم‌ها'],
              ['bi-clipboard-data', 'تهیهٔ گزارش‌های ساختاریافته'],
              ['bi-search', 'جست‌وجو در دانش و مستندات داخلی'],
              ['bi-clock-history', 'خودکارسازی کارهای اداری تکراری'],
              ['bi-link-45deg', 'اتصال چند ابزار کسب‌وکار به یکدیگر'],
            ] as $n => $ex)
              <div class="col-12 col-sm-6"><div class="example reveal" data-delay="{{ $n % 2 * 0.08 }}"><i class="bi {{ $ex[0] }}" aria-hidden="true"></i><span>{{ $ex[1] }}</span></div></div>
            @endforeach
          </div>
        </div>
        <div class="col-12 col-lg-5">
          <div class="agent-log reveal" role="img" aria-label="نمونهٔ مفهومی از لاگ اجرای یک ایجنت">
            <div class="agent-log__bar"><i></i><i></i><i></i><span>agent.log · demo</span></div>
<pre><span class="d"># illustrative example — not real output</span>
<span class="t">[input]</span>   new email received
<span class="t">[analyze]</span> intent = invoice_correction
<span class="t">[tools]</span>   crm.find_customer()  <span class="o">ok</span>
<span class="t">[tools]</span>   erp.create_task()    <span class="o">ok</span>
<span class="t">[report]</span>  assigned to accounting</pre>
          </div>
        </div>
      </div>

      <div class="notice notice--info mt-4">
        <i class="bi bi-info-circle" aria-hidden="true"></i>
        <p>دامنهٔ اتوماسیون به فرایند واقعی کسب‌وکار و امکان اتصال به ابزارهای شما بستگی دارد. پس از بررسی اولیه، روشن می‌کنیم چه چیزی عملی و ارزشمند است.</p>
      </div>
      <div class="d-flex flex-wrap gap-3 mt-4">
        <a class="btn-sd btn-sd--primary" href="{{ route('project-request', ['category' => 'ai-agent']) }}">بررسی امکان ساخت ایجنت اختصاصی <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
        <a class="btn-sd btn-sd--ghost" href="{{ route('service-ai-agents') }}">اطلاعات بیشتر دربارهٔ ایجنت‌ها</a>
      </div>
    </div>
  </section>

  <!-- D. Software repair & rescue -->
  <section class="section pt-0" id="repair" aria-labelledby="repair-title">
    <div class="container">
      <div class="rescue reveal">
        <div class="row g-5 align-items-center">
          <div class="col-12 col-lg-7">
            <span class="eyebrow eyebrow--warn">تعمیر و نجات پروژه</span>
            <h2 id="repair-title">پروژهٔ نرم‌افزاری‌تان به بن‌بست رسیده؟</h2>
            <p>سایت ناگهان از کار افتاده، اپلیکیشن کند شده یا پروژه‌ای از توسعه‌دهندهٔ قبلی به شما رسیده است؟ وضعیت را بررسی می‌کنیم، سیستم را پایدار می‌کنیم، خطاها و گلوگاه‌ها را رفع می‌کنیم و در صورت نیاز توسعه را ادامه می‌دهیم.</p>
            <ul class="symptoms">
              <li><i class="bi bi-x-octagon" aria-hidden="true"></i>وب‌سایتی که ناگهان از کار افتاده</li>
              <li><i class="bi bi-exclamation-triangle" aria-hidden="true"></i>API که خطا برمی‌گرداند</li>
              <li><i class="bi bi-speedometer2" aria-hidden="true"></i>اپلیکیشن لاراولی که کند شده</li>
              <li><i class="bi bi-person-x" aria-hidden="true"></i>پروژهٔ به‌ارث‌رسیده از توسعه‌دهندهٔ قبلی</li>
              <li><i class="bi bi-hourglass-split" aria-hidden="true"></i>اپلیکیشنی نیمه‌کاره</li>
              <li><i class="bi bi-plug" aria-hidden="true"></i>اتصالی که دیگر کار نمی‌کند</li>
              <li><i class="bi bi-arrow-repeat" aria-hidden="true"></i>سیستمی که نیاز به نوسازی دارد</li>
            </ul>
            <div class="d-flex flex-wrap gap-3 align-items-center">
              <a class="btn-sd btn-sd--warn" href="{{ route('project-request', ['category' => 'repair']) }}">ثبت درخواست بررسی پروژه <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
              <a class="link-arrow" href="{{ route('service-software-repair') }}">جزئیات این خدمت <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
            </div>
            <p class="sd-hint mt-3 mb-0">پیش از ارزیابی فنی نمی‌توان رفع هر مشکلی را تضمین کرد؛ اما وضعیت و گزینه‌ها را شفاف توضیح می‌دهیم.</p>
          </div>
          <div class="col-12 col-lg-5">
            <div class="triage">
              <h3>مسیر نجات پروژه</h3>
              <ol>
                <li><span><strong>بررسی و تشخیص</strong>علت مشکل را از روی لاگ‌ها و کد پیدا می‌کنیم.</span></li>
                <li><span><strong>پایدارسازی</strong>سیستم را به وضعیت قابل‌اتکا برمی‌گردانیم.</span></li>
                <li><span><strong>رفع و بهینه‌سازی</strong>باگ‌ها و گلوگاه‌های عملکرد را اصلاح می‌کنیم.</span></li>
                <li><span><strong>ادامهٔ توسعه</strong>در صورت نیاز، کار را با ساختاری منظم ادامه می‌دهیم.</span></li>
              </ol>
              <div class="errlog" role="img" aria-label="مثال نمایشی از یک خطای سرور">
<span class="d"># illustrative example</span>
GET /api/orders  <span class="e">500 Internal Server Error</span>
<span class="e">Allowed memory size exhausted</span>
<span class="o">→ diagnose · stabilize · fix</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- E. How it works -->
  <section class="section section--alt" id="process" aria-labelledby="process-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">فرایند کار</span>
        <h2 id="process-title">چهار قدم از درخواست تا اجرا</h2>
        <p>مسیر همکاری ساده و شفاف است؛ هیچ تعهدی پیش از توافق روی دامنه و شرایط ایجاد نمی‌شود.</p>
      </div>
      @include('layouts.shop.partials.process-steps')
      <div class="mt-5"><a class="btn-sd btn-sd--primary" href="{{ route('project-request') }}">شروع با ثبت درخواست <i class="bi bi-arrow-left" aria-hidden="true"></i></a></div>
    </div>
  </section>

  <!-- F. Selected work (conceptual demonstrations) -->
  <section class="section" id="work" aria-labelledby="work-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">نمونه‌کارها</span>
        <h2 id="work-title">نمونه‌هایی مفهومی از راهکارها</h2>
        <p>موارد زیر پروژهٔ مشتریان نیستند؛ نمونه‌های نمایشی‌اند که نوع مسئله و شیوهٔ راه‌حل را نشان می‌دهند. مطالعات موردی واقعی پس از دریافت رضایت مشتری، جایگزین آن‌ها می‌شوند.</p>
      </div>
      <div class="row g-4">
        @foreach ($projects as $n => $project)
          <div class="col-12 col-md-6"><x-shop.project-card :project="$project" :delay="$n % 2 * 0.08" /></div>
        @endforeach
      </div>
      <div class="mt-4"><a class="link-arrow" href="{{ route('portfolio') }}">مشاهدهٔ همهٔ نمونه‌ها <i class="bi bi-arrow-left" aria-hidden="true"></i></a></div>
    </div>
  </section>

  <!-- G. Why SmarterDev -->
  <section class="section section--alt" id="why" aria-labelledby="why-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">چرا SmarterDev؟</span>
        <h2 id="why-title">تمرکز روی حل مسئله، نه فقط تحویل کد</h2>
      </div>
      <div class="row g-3 g-lg-4">
        @foreach ([          ['bi-bullseye', 'راهکار متناسب با نیاز واقعی', 'اول مسئلهٔ کسب‌وکار را می‌فهمیم، بعد فناوری را انتخاب می‌کنیم.'],
          ['bi-lightbulb', 'حل مسئله، نه صرفاً تحویل کد', 'هدف، رسیدن به نتیجه‌ای است که کسب‌وکار شما به آن نیاز دارد.'],
          ['bi-tools', 'قابل توسعه و نگهداری', 'کد و معماری را طوری می‌نویسیم که ادامهٔ کار در آینده ساده بماند.'],
          ['bi-folder-symlink', 'امکان کار با پروژه‌های موجود', 'لازم نیست از صفر شروع کنید؛ روی سیستم فعلی شما هم کار می‌کنیم.'],
          ['bi-signpost-2', 'فرایند مرحله‌ای و شفاف', 'دامنه، زمان و هزینه پیش از شروع روشن می‌شود و پیشرفت کار قابل پیگیری است.'],
          ['bi-stars', 'استفادهٔ هدفمند از هوش مصنوعی', 'از هوش مصنوعی و اتوماسیون جایی استفاده می‌کنیم که واقعاً ارزش ایجاد کند.'],
        ] as $n => $w)
          <div class="col-12 col-md-6 col-lg-4">
            <div class="why-item reveal" data-delay="{{ $n % 3 * 0.08 }}">
              <span class="icon-tile icon-tile--cyan" aria-hidden="true"><i class="bi {{ $w[0] }}"></i></span>
              <div><h3>{{ $w[1] }}</h3><p>{{ $w[2] }}</p></div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- H. Founder -->
  @include('layouts.shop.partials.founder-section')

  <!-- I. FAQ -->
  <section class="section section--alt" id="faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="row g-5">
        <div class="col-12 col-lg-4">
          <span class="eyebrow">پرسش‌های متداول</span>
          <h2 id="faq-title">پیش از شروع، این‌ها را بدانید</h2>
          <p>پاسخ سؤال‌تان را پیدا نکردید؟ می‌توانید مستقیماً درخواست خود را ثبت کنید یا از صفحهٔ تماس پیام بدهید.</p>
          <a class="link-arrow" href="{{ route('contact') }}">تماس با ما <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
        </div>
        <div class="col-12 col-lg-8">
          <div class="faq" data-faq>
            @foreach ($faqs as $n => $faq)<x-shop.faq-item :faq="$faq" :id="'home-' . ($n + 1)" />@endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- J. Final CTA -->
  <section class="section" aria-label="ثبت درخواست پروژه">
    <div class="container">
      <x-shop.cta-band title="پروژهٔ بعدی شما از یک گفت‌وگوی ساده شروع می‌شود" text="نیازتان را توضیح دهید تا مسیر مناسب برای اجرا یا بهبود آن را بررسی کنیم." label="ثبت درخواست پروژه" :href="route('project-request')" />
    </div>
  </section>

</main>
@endsection

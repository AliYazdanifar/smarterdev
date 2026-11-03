@extends('layouts.shop.master')

@section('content')
@include('layouts.shop.partials.page-hero', [
    'page' => $page,
    'eyebrow' => 'نمونه‌کارها',
    'h1' => 'نمونه‌کارها و مطالعات موردی',
    'lead' => 'در این بخش نمونه‌هایی مفهومی از نوع مسائل و راهکارها را می‌بینید. مطالعات موردی واقعی، پس از دریافت رضایت مشتریان، جایگزین این نمونه‌ها می‌شود.',
])
<main id="main">
  <section class="section"><div class="container">
    <h2 class="visually-hidden">فهرست نمونه‌ها</h2>
    <div class="notice mb-5"><i class="bi bi-lightbulb" aria-hidden="true"></i><p><strong>شفاف‌سازی:</strong> همهٔ موارد زیر «نمونهٔ مفهومی» با نام‌های فرضی‌اند و پروژهٔ تحویل‌شده به مشتری یا نتیجهٔ واقعی نیستند.</p></div>
    <div class="row g-4">
      @foreach ($projects as $n => $project)
        <div class="col-12 col-md-6"><x-shop.project-card :project="$project" :delay="$n % 2 * 0.08" /></div>
      @endforeach
    </div>
  </div></section>
  <section class="section section--alt"><div class="container">
    <x-shop.cta-band title="پروژهٔ شما می‌تواند نمونهٔ بعدی باشد" text="مسئله‌تان را توضیح دهید تا بررسی کنیم کدام راهکار برایش مناسب است." label="ثبت درخواست پروژه" :href="route('project-request')" />
  </div></section>
</main>
@endsection

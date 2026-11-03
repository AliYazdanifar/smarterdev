@extends('layouts.shop.master')

@section('content')
<main id="main">
  <div class="container nf">
    <div class="nf__code" aria-hidden="true">404</div>
    <h1 class="h2">صفحه‌ای که دنبالش بودید پیدا نشد</h1>
    <p>ممکن است نشانی تغییر کرده یا اشتباه تایپ شده باشد. از یکی از مسیرهای زیر ادامه دهید.</p>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <a class="btn-sd btn-sd--primary" href="{{ route('home') }}">بازگشت به صفحهٔ اصلی</a>
      <a class="btn-sd btn-sd--ghost" href="{{ route('services') }}">مشاهدهٔ خدمات</a>
      <a class="btn-sd btn-sd--ghost" href="{{ route('contact') }}">تماس</a>
    </div>
  </div>
</main>
@endsection

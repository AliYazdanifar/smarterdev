@extends('layouts.shop.master')

@section('content')
@include('layouts.shop.partials.page-hero', [
    'page' => $page,
    'eyebrow' => 'مقالات',
    'h1' => 'مقالات و یادداشت‌های فنی',
    'lead' => 'راهنماهای کوتاه و کاربردی برای تصمیم‌گیری دربارهٔ نرم‌افزار، هوش مصنوعی و اتوماسیون؛ بدون اصطلاحات غیرضروری.',
])
<main id="main">
  <section class="section" aria-label="فهرست مقالات"><div class="container">
    <div class="row g-4">
      @foreach ($posts as $slug => $post)
        <div class="col-12 col-md-6 col-lg-4">
          <article class="post-card reveal">
            <div class="post-meta"><span class="chip">{{ $post['category'] }}</span><span><i class="bi bi-clock" aria-hidden="true"></i> {{ $post['read'] }}</span></div>
            <h2><a class="stretched-link" href="{{ route('blog-post', ['slug' => $slug]) }}">{{ $post['title'] }}</a></h2>
            <p>{{ $post['excerpt'] }}</p>
          </article>
        </div>
      @endforeach
    </div>
  </div></section>
</main>
@endsection

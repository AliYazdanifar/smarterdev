@extends('layouts.shop.master')

@section('content')
<main id="main">
  <section class="page-hero dot-grid"><div class="container">
    @include('layouts.shop.partials.breadcrumb', ['page' => $page])
    <div class="page-hero__inner">
      <div class="post-meta mb-3"><span class="chip">{{ $post['category'] }}</span><span><i class="bi bi-clock" aria-hidden="true"></i> {{ $post['read'] }}</span><time datetime="{{ $post['date'] }}">{{ fa_num($post['date']) }}</time></div>
      <h1>{{ $post['title'] }}</h1>
      <p class="page-hero__lead">{{ $post['excerpt'] }}</p>
    </div>
  </div></section>

  <section class="section"><div class="container">
    <div class="article-layout">
      <article class="prose">
        @foreach ($post['body'] as $block)
          @if (! empty($block['h2']))<h2>{{ $block['h2'] }}</h2>@endif
          @foreach (($block['p'] ?? []) as $p)<p>{{ $p }}</p>@endforeach
          @if (! empty($block['ul']))<ul>@foreach ($block['ul'] as $li)<li>{{ $li }}</li>@endforeach</ul>@endif
          @if (! empty($block['ol']))<ol>@foreach ($block['ol'] as $li)<li>{{ $li }}</li>@endforeach</ol>@endif
        @endforeach
      </article>
      <aside class="article-aside" aria-labelledby="aside-title">
        <div class="surface">
          <h2 id="aside-title">پروژه‌ای در همین زمینه دارید؟</h2>
          <p class="small">نیازتان را توضیح دهید تا امکان‌سنجی و مسیر اجرا را بررسی کنیم.</p>
          <a class="btn-sd btn-sd--primary btn-sd--block btn-sd--sm" href="{{ route('project-request', ['category' => $post['cta']['category']]) }}">{{ $post['cta']['label'] }}</a>
        </div>
      </aside>
    </div>
    <p class="mt-5"><a class="link-arrow" href="{{ route('blog') }}"><i class="bi bi-arrow-right" aria-hidden="true"></i> بازگشت به مقالات</a></p>
  </div></section>
</main>
@endsection

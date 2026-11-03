@php
    $current = $page['route'];
    $isActive = static function (array $item) use ($current): bool {
        if (! empty($item['hash'])) {
            return false;
        }
        $r = $item['route'];
        if ($r === 'services') {
            return $current === 'services' || str_starts_with($current, 'service-');
        }
        if ($r === 'blog') {
            return in_array($current, ['blog', 'blog-post'], true);
        }

        return $r === $current;
    };
    $ctaUrl = route('project-request');
@endphp
<a class="skip-link" href="#main">پرش به محتوای اصلی</a>

<header class="site-header" id="site-header">
  <div class="container site-header__bar">
    <a class="brand" href="{{ route('home') }}" aria-label="SmarterDev — صفحه اصلی">
      @include('layouts.shop.partials.logo-mark')
      <span class="brand__word">Smarter<b>Dev</b></span>
    </a>

    <nav class="site-nav d-none d-lg-block" aria-label="ناوبری اصلی">
      <ul>
        @foreach (site('nav') as $item)
          <li><a href="{{ sd_url($item['route'], [], $item['hash'] ?? '') }}"@if($isActive($item)) aria-current="page"@endif>{{ $item['label'] }}</a></li>
        @endforeach
      </ul>
    </nav>

    <div class="site-header__actions">
      <button class="icon-btn theme-toggle" type="button" data-theme-toggle aria-label="تغییر به تم روشن" aria-pressed="false">
        <i class="bi bi-moon-stars-fill" aria-hidden="true"></i><i class="bi bi-sun-fill" aria-hidden="true"></i>
      </button>
      <a class="btn-sd btn-sd--primary btn-sd--sm d-none d-sm-inline-flex" href="{{ $ctaUrl }}">ثبت درخواست پروژه</a>
      <button class="icon-btn d-lg-none" type="button" data-drawer-open aria-expanded="false" aria-controls="mobile-drawer" aria-label="باز کردن منو">
        <i class="bi bi-list" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</header>

<div class="drawer-overlay" data-drawer-overlay></div>
<aside class="drawer" id="mobile-drawer" role="dialog" aria-modal="true" aria-label="منوی اصلی" tabindex="-1">
  <div class="drawer__top">
    <a class="brand" href="{{ route('home') }}" aria-label="SmarterDev — صفحه اصلی">
      @include('layouts.shop.partials.logo-mark')
      <span class="brand__word">Smarter<b>Dev</b></span>
    </a>
    <button class="icon-btn" type="button" data-drawer-close aria-label="بستن منو"><i class="bi bi-x-lg" aria-hidden="true"></i></button>
  </div>
  <nav aria-label="ناوبری موبایل">
    <ul class="drawer__nav">
      @foreach (site('nav') as $item)
        <li><a href="{{ sd_url($item['route'], [], $item['hash'] ?? '') }}"@if($isActive($item)) aria-current="page"@endif><i class="bi {{ $item['icon'] ?? 'bi-dot' }}" aria-hidden="true"></i>{{ $item['label'] }}</a></li>
      @endforeach
      <li><a href="{{ route('contact') }}"@if($current === 'contact') aria-current="page"@endif><i class="bi bi-chat-dots" aria-hidden="true"></i>تماس</a></li>
    </ul>
  </nav>
  <div class="drawer__foot">
    <a class="btn-sd btn-sd--primary btn-sd--block" href="{{ $ctaUrl }}">ثبت درخواست پروژه <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
    <p class="drawer__note text-muted-sd">بررسی اولیه نیاز شما، پیش از هر تعهدی انجام می‌شود.</p>
  </div>
</aside>

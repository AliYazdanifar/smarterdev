@php
    $services = sd_content('services');
    $contact = site('contact');
    $social = site('social', []);
    $socialIcons = ['github' => 'bi-github', 'linkedin' => 'bi-linkedin', 'telegram' => 'bi-telegram', 'instagram' => 'bi-instagram', 'x' => 'bi-twitter-x', 'youtube' => 'bi-youtube'];
@endphp
<footer class="site-footer">
  <div class="container">
    <div class="row g-4 g-lg-5">
      <div class="col-12 col-lg-4">
        <a class="brand" href="{{ route('home') }}" aria-label="SmarterDev — صفحه اصلی">
          @include('layouts.shop.partials.logo-mark')
          <span class="brand__word">Smarter<b>Dev</b></span>
        </a>
        <p class="footer-about">توسعه نرم‌افزار اختصاصی، ایجنت‌های هوش مصنوعی، اتوماسیون کسب‌وکار و تعمیر پروژه‌های موجود؛ با تمرکز بر راهکاری که واقعاً به فرایند شما می‌خورد.</p>
        @if ($social)
          <div class="footer-social">
            @foreach ($social as $name => $url)
              <a class="icon-btn" href="{{ $url }}" rel="noopener" target="_blank" aria-label="{{ ucfirst($name) }}"><i class="bi {{ $socialIcons[$name] ?? 'bi-link-45deg' }}" aria-hidden="true"></i></a>
            @endforeach
          </div>
        @endif
      </div>

      <div class="col-6 col-md-4 col-lg-3">
        <h2>خدمات</h2>
        <ul class="footer-list">
          @foreach (site('footer_services') as $key)
            <li><a href="{{ route($key) }}">{{ $services[$key]['title'] }}</a></li>
          @endforeach
        </ul>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <h2>پیمایش</h2>
        <ul class="footer-list">
          @foreach (site('nav') as $item)
            <li><a href="{{ sd_url($item['route'], [], $item['hash'] ?? '') }}">{{ $item['label'] }}</a></li>
          @endforeach
          <li><a href="{{ route('contact') }}">تماس</a></li>
          <li><a href="{{ route('project-request') }}">ثبت درخواست پروژه</a></li>
        </ul>
      </div>

      <div class="col-12 col-md-4 col-lg-3">
        <h2>تماس</h2>
        <ul class="footer-list">
          <li>
            <i class="bi bi-envelope" aria-hidden="true"></i>
            @if (! empty($contact['email']))
              <a class="ltr" href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>
            @else
              <span class="is-placeholder">ایمیل — به‌زودی</span>
            @endif
          </li>
          <li>
            <i class="bi bi-telephone" aria-hidden="true"></i>
            @if (! empty($contact['phone']))
              <a href="tel:{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>
            @else
              <span class="is-placeholder">شماره تماس — به‌زودی</span>
            @endif
          </li>
          <li>
            <i class="bi bi-send" aria-hidden="true"></i>
            @if (! empty($contact['telegram']))
              <a href="{{ $contact['telegram'] }}" rel="noopener" target="_blank">پیام‌رسان</a>
            @else
              <span class="is-placeholder">پیام‌رسان — به‌زودی</span>
            @endif
          </li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© {{ fa_num(date('Y')) }} SmarterDev — همهٔ حقوق محفوظ است.</span>
      <span><a href="{{ route('privacy') }}">حریم خصوصی</a></span>
    </div>
  </div>
</footer>

@if ($page['mobile_cta'])
<div class="mobile-cta d-lg-none" data-mobile-cta>
  <a class="btn-sd btn-sd--primary btn-sd--block" href="{{ route('project-request') }}">ثبت درخواست پروژه <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
</div>
@endif

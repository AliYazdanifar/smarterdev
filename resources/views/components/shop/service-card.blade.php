@props(['key', 'svc', 'delay' => 0])
<article class="svc-card reveal"@if($delay) data-delay="{{ $delay }}"@endif>
  <span class="icon-tile" aria-hidden="true"><i class="bi {{ $svc['icon'] }}"></i></span>
  <h3>{{ $svc['title'] }}</h3>
  <p>{{ $svc['short'] }}</p>
  <ul class="check-list">
    @foreach ($svc['caps'] as $cap)<li>{{ $cap }}</li>@endforeach
  </ul>
  <a class="link-arrow svc-card__more stretched-link" href="{{ route($key) }}">بررسی این خدمت <i class="bi bi-arrow-left" aria-hidden="true"></i><span class="visually-hidden">: {{ $svc['title'] }}</span></a>
</article>

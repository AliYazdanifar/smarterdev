@php $actions = $actions ?? []; @endphp
<section class="page-hero dot-grid">
  <div class="container">
    @include('layouts.shop.partials.breadcrumb', ['page' => $page])
    <div class="page-hero__inner">
      @if (! empty($eyebrow))<span class="eyebrow">{{ $eyebrow }}</span>@endif
      <h1>{{ $h1 }}</h1>
      @if (! empty($lead))<p class="page-hero__lead">{{ $lead }}</p>@endif
      @if ($actions)
        <div class="d-flex flex-wrap gap-3 mt-4">
          @foreach ($actions as $a)
            <a class="btn-sd btn-sd--{{ $a[2] ?? 'primary' }}" href="{{ $a[1] }}">{{ $a[0] }}@if(($a[2] ?? 'primary') === 'primary') <i class="bi bi-arrow-left" aria-hidden="true"></i>@endif</a>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</section>

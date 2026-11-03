@php $f = site('founder'); @endphp
<section class="section" id="founder" aria-labelledby="founder-title">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-12 col-md-5 col-lg-4 reveal">@include('layouts.shop.partials.founder-portrait')</div>
      <div class="col-12 col-md-7 col-lg-8 reveal" data-delay="0.1">
        <span class="eyebrow">درباره بنیان‌گذار</span>
        <h2 id="founder-title">پشت SmarterDev یک توسعه‌دهندهٔ واقعی ایستاده است</h2>
        @if (! empty($f['name']))<p class="fw-bold text-body mb-1">{{ $f['name'] }}</p>@endif
        <p class="small mb-3">{{ $f['role'] }}</p>
        @foreach ($f['bio'] as $para)<p>{{ $para }}</p>@endforeach
        <ul class="check-list my-4 col-lg-9">
          @foreach ($f['focus'] as $item)<li>{{ $item }}</li>@endforeach
        </ul>
        @if (empty($f['name']))
          <p class="sd-hint mb-3"><i class="bi bi-pencil-square" aria-hidden="true"></i> نام و جزئیات شخصی را در <span class="mono">config/smarterdev.php</span> تکمیل کنید.</p>
        @endif
        <a class="btn-sd btn-sd--primary" href="{{ route('project-request') }}">درباره پروژه‌تان صحبت کنیم <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>
</section>

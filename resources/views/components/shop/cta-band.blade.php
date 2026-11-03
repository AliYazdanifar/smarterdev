@props(['title', 'text', 'label', 'href', 'secondary' => null])
<div class="cta-band reveal">
  <span class="cta-band__node cta-band__node--1" aria-hidden="true"></span>
  <span class="cta-band__node cta-band__node--2" aria-hidden="true"></span>
  <span class="cta-band__node cta-band__node--3" aria-hidden="true"></span>
  <h2>{{ $title }}</h2>
  <p>{{ $text }}</p>
  <div class="cta-band__actions">
    <a class="btn-sd btn-sd--primary" href="{{ $href }}">{{ $label }} <i class="bi bi-arrow-left" aria-hidden="true"></i></a>
    @if ($secondary)
      <a class="btn-sd btn-sd--ghost" href="{{ $secondary[1] }}">{{ $secondary[0] }}</a>
    @endif
  </div>
</div>

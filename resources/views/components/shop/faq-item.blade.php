@props(['faq', 'id'])
<div class="faq-item">
  <h3><button class="faq-btn" type="button" id="faq-btn-{{ $id }}" aria-controls="faq-panel-{{ $id }}" aria-expanded="true">
    <span>{{ $faq[0] }}</span><i class="bi bi-plus-lg" aria-hidden="true"></i>
  </button></h3>
  <div class="faq-a" id="faq-panel-{{ $id }}" role="region" aria-labelledby="faq-btn-{{ $id }}">
    <div><p>{{ $faq[1] }}</p></div>
  </div>
</div>

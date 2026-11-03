@props(['project', 'delay' => 0])
<article class="pcard reveal"@if($delay) data-delay="{{ $delay }}"@endif>
  <div class="pcard__mock" aria-hidden="true">
    <span class="pcard__bar pcard__bar--a"></span><span class="pcard__bar pcard__bar--b"></span><span class="pcard__bar pcard__bar--c"></span>
    <i class="bi {{ $project['icon'] }} pcard__ico"></i>
  </div>
  <div class="pcard__body">
    <div class="pcard__meta">
      @if (! empty($project['demo']))<span class="chip chip--demo"><i class="bi bi-lightbulb" aria-hidden="true"></i>نمونهٔ مفهومی</span>@endif
      <span class="chip">{{ $project['category'] }}</span>
    </div>
    <h3>{{ $project['name'] }}</h3>
    <dl>
      <div><dt>مسئله</dt><dd>{{ $project['problem'] }}</dd></div>
      <div><dt>راهکار پیشنهادی</dt><dd>{{ $project['solution'] }}</dd></div>
    </dl>
    <div class="pcard__tech" aria-label="فناوری‌ها">
      @foreach ($project['tech'] as $t)<span class="chip chip--tech">{{ $t }}</span>@endforeach
    </div>
  </div>
</article>

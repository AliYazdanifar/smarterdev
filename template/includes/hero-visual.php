<?php /** Homepage hero illustration: original SVG robot-bust + neural network + floating (decorative) interface panels. */ ?>
<div class="hero-visual" role="img" aria-label="تصویر مفهومی از یک ایجنت هوش مصنوعی که گردش‌کار کسب‌وکار را اجرا می‌کند">
  <svg class="hv-svg" viewBox="0 0 600 600" width="600" height="600" fill="none" aria-hidden="true" focusable="false">
    <defs>
      <radialGradient id="hv-glow" cx="50%" cy="46%" r="50%">
        <stop offset="0" class="hv-s-accent" stop-opacity=".42"/>
        <stop offset=".55" class="hv-s-accent" stop-opacity=".08"/>
        <stop offset="1" class="hv-s-accent" stop-opacity="0"/>
      </radialGradient>
      <linearGradient id="hv-metal" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0" class="hv-s-robot1"/>
        <stop offset="1" class="hv-s-robot2"/>
      </linearGradient>
      <radialGradient id="hv-eye" cx="50%" cy="40%" r="60%">
        <stop offset="0" stop-color="#E8FBFF"/>
        <stop offset=".45" class="hv-s-cyan"/>
        <stop offset="1" class="hv-s-cyan" stop-opacity=".55"/>
      </radialGradient>
      <linearGradient id="hv-pulse" x1="0" y1="0" x2="1" y2="0">
        <stop offset="0" class="hv-s-accent"/>
        <stop offset="1" class="hv-s-cyan"/>
      </linearGradient>
      <filter id="hv-blur" x="-60%" y="-60%" width="220%" height="220%"><feGaussianBlur stdDeviation="7"/></filter>
    </defs>

    <circle cx="300" cy="290" r="270" fill="url(#hv-glow)"/>
    <ellipse class="hv-ring" cx="300" cy="300" rx="250" ry="250" stroke-dasharray="2 9"/>

    <!-- neural network -->
    <g class="hv-net">
      <path d="M70 170 Q132 205 196 262"/>
      <path d="M95 332 Q150 300 196 270"/>
      <path d="M130 90 Q95 125 70 170"/>
      <path d="M130 90 Q215 105 300 138"/>
      <path d="M205 45 Q250 90 300 138"/>
      <path d="M300 55 L300 124"/>
      <path d="M410 60 Q360 95 300 138"/>
      <path d="M410 60 Q480 90 535 150"/>
      <path d="M535 150 Q470 190 404 262"/>
      <path d="M485 262 Q440 266 404 270"/>
      <path d="M545 400 Q500 330 485 262"/>
      <path d="M470 500 Q450 480 430 470"/>
      <path d="M60 470 Q120 470 170 470"/>
      <path d="M95 332 Q70 400 60 470"/>
      <path d="M545 400 Q520 450 470 500"/>
    </g>
    <g class="hv-pulses">
      <path class="hv-pulse hv-pulse--1" d="M70 170 Q132 205 196 262"/>
      <path class="hv-pulse hv-pulse--2" d="M535 150 Q470 190 404 262"/>
      <path class="hv-pulse hv-pulse--3" d="M205 45 Q250 90 300 138"/>
      <path class="hv-pulse hv-pulse--4" d="M545 400 Q500 330 485 262"/>
      <path class="hv-pulse hv-pulse--5" d="M95 332 Q150 300 196 270"/>
    </g>
    <g class="hv-nodes">
      <circle cx="70" cy="170" r="5"/><circle cx="130" cy="90" r="4"/><circle cx="95" cy="332" r="5"/><circle cx="60" cy="470" r="4"/>
      <circle cx="535" cy="150" r="5"/><circle cx="485" cy="262" r="4"/><circle cx="545" cy="400" r="5"/><circle cx="470" cy="500" r="4"/>
      <circle cx="300" cy="55" r="4"/><circle cx="205" cy="45" r="3"/><circle cx="410" cy="60" r="4"/>
    </g>
    <g class="hv-particles">
      <circle class="hv-dot hv-dot--1" cx="160" cy="210" r="2"/><circle class="hv-dot hv-dot--2" cx="440" cy="190" r="2.4"/>
      <circle class="hv-dot hv-dot--3" cx="120" cy="420" r="2"/><circle class="hv-dot hv-dot--4" cx="500" cy="330" r="2"/>
      <circle class="hv-dot hv-dot--5" cx="250" cy="90" r="1.8"/><circle class="hv-dot hv-dot--6" cx="360" cy="110" r="2"/>
      <circle class="hv-dot hv-dot--7" cx="80" cy="260" r="1.8"/><circle class="hv-dot hv-dot--8" cx="520" cy="470" r="2.2"/>
    </g>

    <!-- robot bust -->
    <g class="hv-robot">
      <!-- torso -->
      <path class="hv-body" d="M104 606C104 508 164 448 240 432L360 432C436 448 496 508 496 606Z" fill="url(#hv-metal)"/>
      <path class="hv-seam" d="M214 606C214 548 240 500 300 490C360 500 386 548 386 606"/>
      <path class="hv-seam" d="M238 436Q300 458 362 436"/>
      <path class="hv-seam hv-seam--soft" d="M150 520L190 486M450 520L410 486"/>
      <!-- core -->
      <circle class="hv-core-ring" cx="300" cy="544" r="25"/>
      <circle class="hv-core" cx="300" cy="544" r="9"/>
      <!-- neck -->
      <rect class="hv-body" x="268" y="368" width="64" height="76" rx="14" fill="url(#hv-metal)"/>
      <path class="hv-seam" d="M276 398H324M276 412H324"/>
      <!-- ears -->
      <rect class="hv-body" x="192" y="236" width="22" height="62" rx="11" fill="url(#hv-metal)"/>
      <rect class="hv-body" x="386" y="236" width="22" height="62" rx="11" fill="url(#hv-metal)"/>
      <path class="hv-accent-line" d="M203 250V284M397 250V284"/>
      <!-- head -->
      <rect class="hv-body" x="210" y="166" width="180" height="204" rx="72" fill="url(#hv-metal)"/>
      <path class="hv-highlight" d="M246 192Q300 168 354 192"/>
      <!-- visor -->
      <rect class="hv-visor" x="232" y="210" width="136" height="100" rx="42"/>
      <g class="hv-eyes">
        <rect x="266" y="246" width="26" height="32" rx="13" fill="#22C8E6" filter="url(#hv-blur)" opacity=".75"/>
        <rect x="308" y="246" width="26" height="32" rx="13" fill="#22C8E6" filter="url(#hv-blur)" opacity=".75"/>
        <rect x="268" y="248" width="22" height="28" rx="11" fill="url(#hv-eye)"/>
        <rect x="310" y="248" width="22" height="28" rx="11" fill="url(#hv-eye)"/>
      </g>
      <path class="hv-seam" d="M278 338H322"/>
      <!-- antenna -->
      <path class="hv-seam" d="M300 166V140"/>
      <circle class="hv-halo" cx="300" cy="130" r="13"/>
      <circle class="hv-antenna" cx="300" cy="130" r="6"/>
    </g>
  </svg>

  <!-- floating panels (decorative) -->
  <div class="hv-panel hv-panel--code ltr" aria-hidden="true">
    <div class="hv-panel__bar"><i></i><i></i><i></i><span>agent.py</span></div>
    <pre><code><b>msg</b> = inbox.next()
<b>intent</b> = agent.classify(msg)
crm.<em>create_ticket</em>(intent)
report.<em>send</em>()</code></pre>
  </div>

  <div class="hv-panel hv-panel--flow" aria-hidden="true">
    <div class="hv-panel__title"><span>گردش‌کار نمونه</span><small>نمایشی</small></div>
    <ul>
      <li class="is-done"><i class="bi bi-check-circle-fill"></i>دریافت پیام مشتری</li>
      <li class="is-done"><i class="bi bi-check-circle-fill"></i>دسته‌بندی هوشمند</li>
      <li class="is-run"><i class="bi bi-arrow-repeat"></i>ثبت در CRM</li>
      <li><i class="bi bi-circle"></i>ارسال گزارش</li>
    </ul>
  </div>

  <div class="hv-panel hv-panel--toast" aria-hidden="true">
    <i class="bi bi-lightning-charge-fill"></i>
    <span>درخواست دسته‌بندی و ارجاع شد<small>نمونهٔ مفهومی</small></span>
  </div>
</div>

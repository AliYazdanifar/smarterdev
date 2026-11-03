<?php

$f = dirname(__DIR__).'/resources/views/shop/pages/home.blade.php';
$s = file_get_contents($f);
$s = preg_replace('/<\?= e\((route\([^)]+\)(?:, \[[^\]]*\])?)\) \?>/', '{{ $1 }}', $s);
$s = str_replace('<?php @include', '@include', $s);
$s = preg_replace("/<\?php component\('service-card', \['key' => \\\$key, 'svc' => \\\$svc, 'delay' => \(([^)]+)\)\]\); \?>/", '<x-shop.service-card :key="$key" :svc="$svc" :delay="$1" />', $s);
$s = str_replace('<?php <x-shop.project-card', '<x-shop.project-card', $s);
$s = str_replace(' /> ?>', ' />', $s);
$s = preg_replace('/<\?php foreach \(\$faqs as \$n => \$faq\) \{ <x-shop\.faq-item :faq="\$faq" :id="\'home-\' \. \(\$n \+ 1\)" \/> \} \?>/', '@foreach ($faqs as $n => $faq)<x-shop.faq-item :faq="$faq" :id="\'home-\' . ($n + 1)" />@endforeach', $s);
$s = preg_replace('/@foreach \(\[\s*\n\s*\[\'bi-signpost-split\'/', "@foreach([\n              ['bi-signpost-split'", $s);
$s = preg_replace("/\] as \\\$n => \\\$ex\) @endphp/", '] as $n => $ex)', $s);
$s = preg_replace('/@php \$cta = \[[^\]]+\]; @endphp<x-shop\.cta-band[^\/]+\/>/', '<x-shop.cta-band title="پروژهٔ بعدی شما از یک گفت‌وگوی ساده شروع می‌شود" text="نیازتان را توضیح دهید تا مسیر مناسب برای اجرا یا بهبود آن را بررسی کنیم." label="ثبت درخواست پروژه" :href="route(\'project-request\')" />', $s);
file_put_contents($f, $s);
echo "fixed\n";

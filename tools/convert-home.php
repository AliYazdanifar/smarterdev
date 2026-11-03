<?php

declare(strict_types=1);

$base = dirname(__DIR__);
$pages = [
    'index.php' => 'home.blade.php',
];

function phpToBlade(string $html): string
{
    $html = preg_replace('/<\?= e\(([^)]+)\) \?>/', '{{ $1 }}', $html);
    $html = preg_replace("/component\('service-card', \['key' => \\\$key, 'svc' => \\\$svc, 'delay' => \(([^)]+)\)\]\);/", '<x-shop.service-card :key="$key" :svc="$svc" :delay="$1" />', $html);
    $html = preg_replace("/component\('project-card', \['project' => \\\$project, 'delay' => ([^]]+)\]\);/", '<x-shop.project-card :project="$project" :delay="$1" />', $html);
    $html = preg_replace("/component\('faq-item', \['faq' => \\\$faq, 'id' => '([^']+)'\]\);/", '<x-shop.faq-item :faq="$faq" id="$1" />', $html);
    $html = preg_replace("/component\('faq-item', \['faq' => \\\$faq, 'id' => ([^]]+)\]\);/", '<x-shop.faq-item :faq="$faq" :id="$1" />', $html);
    $html = preg_replace("/component\('cta-band', \[([^\]]+)\]\);/", '@php $cta = [$1]; @endphp<x-shop.cta-band :title="$cta[\'title\']" :text="$cta[\'text\']" :label="$cta[\'label\']" :href="$cta[\'href\']" />', $html);
    $html = str_replace("component('process-steps');", "@include('layouts.shop.partials.process-steps')", $html);
    $html = str_replace("component('founder-section');", "@include('layouts.shop.partials.founder-section')", $html);
    $html = str_replace("component('hero-visual');", "@include('layouts.shop.partials.hero-visual')", $html);
    $html = preg_replace('/<\?php \$i = 0; foreach \(\$services as \$key => \$svc\): \?>/', '@php $i = 0 @endphp @foreach ($services as $key => $svc)', $html);
    $html = preg_replace('/<\?php endforeach; \?>/', '@endforeach', $html);
    $html = preg_replace('/<\?php foreach \(\$projects as \$n => \$project\): \?>/', '@foreach ($projects as $n => $project)', $html);
    $html = preg_replace('/<\?php foreach \(\$faqs as \$n => \$faq\) \{ component\([^}]+\} \?>/', '@foreach ($faqs as $n => $faq) <x-shop.faq-item :faq="$faq" :id="\'home-\' . ($n + 1)" /> @endforeach', $html);
    $html = preg_replace('/<\?php foreach \(\[\s*\n/', '@foreach ([', $html);
    $html = preg_replace('/\] as \$n => \$ex\): \?>/', '] as $n => $ex) @endphp', $html);
    $html = preg_replace('/<\?php foreach \(\[\s*\[/', '@foreach ([[', $html);
    $html = preg_replace('/\] as \$n => \$w\): \?>/', '] as $n => $w) @endphp', $html);
    $html = preg_replace('/<\?php endforeach; \?>/', '@endforeach', $html);

    return $html;
}

$src = file_get_contents($base.'/template/index.php');
$start = strpos($src, '<main id="main">');
$end = strrpos($src, '</main>') + 7;
$body = substr($src, $start, $end - $start);
$body = phpToBlade($body);

$out = "@extends('layouts.shop.master')\n\n@section('content')\n".$body."\n@endsection\n";
file_put_contents($base.'/resources/views/shop/pages/home.blade.php', $out);
echo "Wrote home.blade.php\n";

<?php

$f = dirname(__DIR__).'/resources/views/shop/pages/project-request.blade.php';
$s = file_get_contents($f);

$s = preg_replace('/<\?= e\((route\([^)]+\)(?:, \[[^\]]*\])?)\) \?>/', '{{ $1 }}', $s);
$s = preg_replace('/<\?= \$choice\(([^)]+(?:\([^)]*\)[^)]*)*)\) \?>/', '{!! $choice($1) !!}', $s);
$s = preg_replace('/<\?php foreach \(\$stepLabels as \$i => \$l\): \?><li><span class="n"><span><\?= e\(fa_num\(\$i \+ 1\)\) \?><\/span><\/span>\{\{ \$l \}\}<\/li><\?php endforeach; \?>/', '@foreach ($stepLabels as $i => $l)<li><span class="n"><span>{{ fa_num($i + 1) }}</span></span>{{ $l }}</li>@endforeach', $s);
$s = preg_replace('/<\?php foreach \(\$wizard\[\'categories\'\] as \$key => \$c\) \{ echo \$choice\([^}]+\} \?>/', '@foreach ($wizard[\'categories\'] as $key => $c){!! $choice(\'category\', $key, $c[\'label\'], $c[\'hint\'], \'radio\', $c[\'icon\'], true) !!}@endforeach', $s);
$s = preg_replace('/<\?php foreach \(\$wizard\[\'budgets\'\] as \$k => \$label\) \{ echo \$choice\(\'budget\', \$k, \$label\); \} \?>/', '@foreach ($wizard[\'budgets\'] as $k => $label){!! $choice(\'budget\', $k, $label) !!}@endforeach', $s);
$s = preg_replace('/<\?php foreach \(\$wizard\[\'timelines\'\] as \$k => \$label\) \{ echo \$choice\(\'timeline\', \$k, \$label\); \} \?>/', '@foreach ($wizard[\'timelines\'] as $k => $label){!! $choice(\'timeline\', $k, $label) !!}@endforeach', $s);
$s = preg_replace('/<\?php foreach \(\$wizard\[\'urgency\'\] as \$k => \$u\) \{ echo \$choice\(\'urgency\', \$k, \$u\[\'label\'\], \$u\[\'hint\'\]\); \} \?>/', '@foreach ($wizard[\'urgency\'] as $k => $u){!! $choice(\'urgency\', $k, $u[\'label\'], $u[\'hint\']) !!}@endforeach', $s);
$s = preg_replace('/<\?php foreach \(\$wizard\[\'contact_methods\'\] as \$k => \$label\) \{ echo \$choice\(\'contact_method\', \$k, \$label\); \} \?>/', '@foreach ($wizard[\'contact_methods\'] as $k => $label){!! $choice(\'contact_method\', $k, $label) !!}@endforeach', $s);

$s = str_replace('data-gate aria-labelledby="gate-title"<?= $entered ? \' hidden\' : \'\' ?>', 'data-gate aria-labelledby="gate-title"@if($entered) hidden @endif', $s);
$s = str_replace('data-wizard-root aria-labelledby="wiz-title"<?= $entered ? \'\' : \' hidden\' ?>', 'data-wizard-root aria-labelledby="wiz-title"@if(! $entered) hidden @endif', $s);
$s = preg_replace('/<<\?= \$gateTag \?> id="gate-title" class="h2">ثبت درخواست پروژه<\/<\?= \$gateTag ?>>/', '@if($entered)<h2 id="gate-title" class="h2">ثبت درخواست پروژه</h2>@else<h1 id="gate-title" class="h2">ثبت درخواست پروژه</h1>@endif', $s);
$s = preg_replace('/<<\?= \$wizTag \?> id="wiz-title" class="h3 mb-1">ثبت درخواست پروژه<\/<\?= \$wizTag ?>>/', '@if($entered)<h1 id="wiz-title" class="h3 mb-1">ثبت درخواست پروژه</h1>@else<h2 id="wiz-title" class="h3 mb-1">ثبت درخواست پروژه</h2>@endif', $s);

$s = str_replace('<?= e(fa_num(count($stepLabels))) ?>', '{{ fa_num(count($stepLabels)) }}', $s);
$s = str_replace('aria-valuemax="<?= count($stepLabels) ?>"', 'aria-valuemax="{{ count($stepLabels) }}"', $s);

$s = str_replace('{{ $stepLabels[0] }}', '{{ $stepLabels[0] }}', $s);

file_put_contents($f, $s);
echo "fixed\n";

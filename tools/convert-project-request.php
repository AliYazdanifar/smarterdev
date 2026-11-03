<?php

declare(strict_types=1);

$src = file_get_contents(dirname(__DIR__).'/template/project-request.php');
$start = strpos($src, '<main id="main">');
$end = strrpos($src, '</main>') + 7;
$body = substr($src, $start, $end - $start);

$body = preg_replace('/<\?= e\(([^)]+)\) \?>/', '{{ $1 }}', $body);
$body = preg_replace('/<\?= \$err\(\'([^\']+)\'\) \?>/', '{!! $err(\'$1\') !!}', $body);
$body = str_replace('<?= $req ?>', '{!! $req !!}', $body);
$body = str_replace('<?= $opt ?>', '{!! $opt !!}', $body);
$body = preg_replace('/<\?= \$choice\(([^;]+);\s*echo \$choice\(([^;]+);\s*\?>/', '', $body); // skip complex

$body = str_replace('$W', '$wizard', $body);
$body = preg_replace('/<\?php foreach \(\$W\[\'categories\'\] as \$key => \$c\) \{ echo \$choice\([^}]+\} \?>/', '@foreach ($wizard[\'categories\'] as $key => $c) {!! $choice(\'category\', $key, $c[\'label\'], $c[\'hint\'], \'radio\', $c[\'icon\'], true) !!} @endforeach', $body);

$out = "@extends('layouts.shop.master')\n\n@php\n    \$W = \$wizard;\n    \$gateTag = \$entered ? 'h2' : 'h1';\n    \$wizTag = \$entered ? 'h1' : 'h2';\n    \$stepLabels = ['دسته‌بندی', 'توضیح پروژه', 'محدوده', 'بودجه و زمان', 'اطلاعات تکمیلی', 'بررسی نهایی'];\n    \$choice = static function (string \$name, string \$value, string \$title, string \$hint = '', string \$type = 'radio', string \$icon = '', bool \$card = false): string {\n        \$id = \$name.'-'.\$value;\n        return '<label class=\"choice'.(\$card ? ' choice--card' : '').'\" for=\"'.e(\$id).'\">'\n            .'<input class=\"choice__input\" type=\"'.e(\$type).'\" name=\"'.e(\$name).'\" id=\"'.e(\$id).'\" value=\"'.e(\$value).'\">'\n            .'<span class=\"choice__body\">'\n            .(\$icon ? '<span class=\"icon-tile\" aria-hidden=\"true\"><i class=\"bi '.e(\$icon).'\"></i></span>' : '')\n            .'<span class=\"choice__text\"><span class=\"choice__title\">'.e(\$title).'</span>'\n            .(\$hint ? '<span class=\"choice__hint\">'.e(\$hint).'</span>' : '').'</span></span></label>';\n    };\n    \$err = static fn (string \$id): string => '<p class=\"field-error\" id=\"'.e(\$id).'-error\" hidden></p>';\n    \$req = '<span class=\"req\" aria-hidden=\"true\">*</span><span class=\"visually-hidden\">(الزامی)</span>';\n    \$opt = '<span class=\"opt\">(اختیاری)</span>';\n@endphp\n\n@section('content')\n".$body."\n@endsection\n";

$dir = dirname(__DIR__).'/resources/views/shop/pages';
if (! is_dir($dir)) {
    mkdir($dir, 0755, true);
}
file_put_contents($dir.'/project-request.blade.php', $out);
echo "wrote project-request\n";

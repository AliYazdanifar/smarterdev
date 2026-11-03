@php
    $page = $page ?? sd_page();
@endphp
<!DOCTYPE html>
<html lang="fa" dir="rtl" data-bs-theme="dark" data-theme="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="{{ site('theme_color') }}">
<title>{{ $page['full_title'] }}</title>
<script src="{{ asset('assets/js/theme-init.js') }}"></script>
@include('layouts.shop.partials.seo', ['page' => $page])
<link rel="icon" href="{{ asset('assets/icons/favicon.svg') }}" type="image/svg+xml">
<link rel="preload" href="{{ asset('assets/fonts/Vazirmatn-Variable.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/bootstrap.rtl.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/tokens.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
@foreach ($page['css'] as $css)
<link rel="stylesheet" href="{{ asset('assets/css/'.$css) }}">
@endforeach
@stack('styles')
</head>
<body class="{{ $page['body_class'] }}">
@include('layouts.shop.partials.header', ['page' => $page])

@yield('content')

@include('layouts.shop.partials.footer', ['page' => $page])
<script src="{{ asset('assets/js/main.js') }}" defer></script>
@foreach ($page['js'] as $js)
<script src="{{ asset('assets/js/'.$js) }}" defer></script>
@endforeach
@stack('scripts')
</body>
</html>

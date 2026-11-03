<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Steach Admin Panel">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ settings('site_favicon') ?: asset('theme/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ settings('site_favicon') ?: asset('theme/images/favicon.png') }}" type="image/x-icon">
    <title>{{ settings('site_name', 'Steach') }} | @yield('title', 'ورود')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/themify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('theme/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/fonts.css') }}">
    @stack('head')
</head>
<body class="rtl">
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-card login-dark">
                <div>
                    <div>
                        <a class="logo" href="{{ route('admin.login') }}">
                            <img class="img-fluid for-light" src="{{ settings('site_logo') ?: asset('theme/images/logo/logo.png') }}" alt="{{ settings('site_name', 'Steach') }}">
                            <img class="img-fluid for-dark" src="{{ settings('site_logo') ?: asset('theme/images/logo/logo_dark.png') }}" alt="{{ settings('site_name', 'Steach') }}">
                        </a>
                    </div>
                    <div class="login-main">
                        @if (session('error'))
                            <div class="alert alert-warning">
                                <p class="mb-0">{{ session('error') }}</p>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('theme/js/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('theme/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('theme/js/config.js') }}"></script>
    <script src="{{ asset('theme/js/script.js') }}"></script>
    <script src="{{ asset('theme/js/admin/csrf.js') }}"></script>
    @stack('script')
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
          content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ settings('site_favicon') ?: asset('theme/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ settings('site_favicon') ?: asset('theme/images/favicon.png') }}" type="image/x-icon">
    <title>{{ settings('site_name', 'Steach') }} | @yield('title')</title>


    <link rel="stylesheet" type="text/css" href="{{asset('theme/css/font-awesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/date-picker.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('theme/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/responsive.css') }}">
    <!-- Custom fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/fonts.css') }}">

    @stack('head')

</head>
<body class="rtl">
<!-- loader starts-->
<div class="loader-wrapper">
    <div class="loader-index"><span></span></div>
    <svg>
        <defs></defs>
        <filter id="goo">
            <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
            <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></fecolormatrix>
        </filter>
    </svg>
</div>
<!-- loader ends-->
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <div class="header-logo-wrapper col-auto p-0">
                <div class="logo-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid"
                                                                    src="{{ settings('site_logo') ?: asset('theme/images/logo/logo.png') }}" alt="{{ settings('site_name', 'Steach') }}"></a>
                </div>
                <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle"
                                               data-feather="align-center"></i></div>
            </div>
            <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
                <div class="notification-slider">
                    <div class="d-flex h-100"><img src="{{ asset('theme/images/giftools.gif') }}" alt="gif">
                        <h6 class="mb-0 f-w-400"><span class="font-primary">Don't Miss Out! </span><span
                                class="f-light">Out new update has been release.</span></h6><i
                            class="icon-arrow-top-right f-light"></i>
                    </div>
                    <div class="d-flex h-100"><img src="{{ asset('theme/images/giftools.gif') }}" alt="gif">
                        <h6 class="mb-0 f-w-400"><span class="f-light">Something you love is now on sale! </span></h6><a
                            class="ms-1" href="https://1.envato.market/3GVzd" target="_blank">Buy now !</a>
                    </div>
                </div>
            </div>
            <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                <ul class="nav-menus">
                    <li>
                        <div class="mode">
                            <svg>
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#moon"></use>
                            </svg>
                        </div>
                    </li>
                    @include('notification::partials.admin-header-notifications')
                    <li class="profile-nav onhover-dropdown pe-0 py-0">
                        <div class="media profile-media"><img class="b-r-10"
                                                              src="{{ asset('theme/images/dashboard/profile.png') }}"
                                                              alt="">
                            <div class="media-body"><span>{{ auth('admin')->user()->name }}</span>
                                <p class="mb-0">مدیر <i class="middle fa fa-angle-down"></i></p>
                            </div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div">
                            <li>
                                <a href="{{ route('admin.profile.edit') }}">
                                    <i data-feather="user"></i><span>ویرایش پروفایل</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.profile.password.edit') }}">
                                    <i data-feather="lock"></i><span>تغییر رمز عبور</span>
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent w-100 text-start">
                                        <i data-feather="log-out"></i><span>خروج</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <script class="result-template" type="text/x-handlebars-template">
                <div class="ProfileCard u-cf">
                    <div class="ProfileCard-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-airplay m-0">
                            <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                            <polygon points="12 15 17 21 7 21 12 15"></polygon>
                        </svg>
                    </div>
                    <div class="ProfileCard-details">
                        <div class="ProfileCard-realName">nameee</div>
                    </div>
                </div>
            </script>
            <script class="empty-template" type="text/x-handlebars-template">
                <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down,
                    yikes!
                </div></script>
        </div>
    </div>
    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        @include('layouts.admin.sidebar')
        <!-- Page Sidebar Ends-->

        <div class="page-body">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="">@yield('title')</h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 footer-copyright text-center">
                        <p class="mb-0">Copyright 2026 © Steach </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- latest jquery-->
<script src="{{ asset('theme/js/jquery.min.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('theme/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- feather icon js-->
<script src="{{ asset('theme/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('theme/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- scrollbar js-->
<script src="{{ asset('theme/js/scrollbar/simplebar.js') }}"></script>
<script src="{{ asset('theme/js/scrollbar/custom.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('theme/js/config.js') }}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('theme/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('theme/js/sidebar-pin.js') }}"></script>
<script src="{{ asset('theme/js/slick/slick.min.js') }}"></script>
<script src="{{ asset('theme/js/slick/slick.js') }}"></script>
<script src="{{ asset('theme/js/header-slick.js') }}"></script>
<script src="{{ asset('theme/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('theme/js/chart/apex-chart/stock-prices.js') }}"></script>
<script src="{{ asset('theme/js/datepicker/date-picker/datepicker.js') }}"></script>
<script src="{{ asset('theme/js/datepicker/date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('theme/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
<script src="{{ asset('theme/js/height-equal.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('theme/js/script.js') }}"></script>
<script src="{{ asset('theme/js/admin/csrf.js') }}"></script>
{{--<script src="{{ asset('theme/js/theme-customizer/customizer.js') }}"></script>--}}

@stack('script')
</body>
</html>

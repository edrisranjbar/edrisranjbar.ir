<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ادریس رنجبر - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v=3') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/splide.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/moovie.min.css') }}">
</head>

<body class="@yield('body-class', '')">
    
    @if (!isset($hideHeader))
    <header class="@yield('header-class', '')">
        @include('templates.main-menu')
    </header>
    @endif

    @yield('content')

    @if (!isset($hideFooter))
    @include('templates.footer')
    @endif
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/splide.min.js') }}"></script>
    <script src="{{ asset('assets/js/moovie.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}" defer></script>
</body>

</html>
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
    <!-- FavIcon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
</head>

<body class="@yield('body-class', '')">

@if (!isset($hideHeader))
    <header>
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
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
    <header>
        @include('templates.main-menu')
    </header>
    @endif

    @yield('content')

    @if (!isset($hideFooter))
    <footer class="pt-5">
        <h2 class="my-text-primary">ادریس رنجبر</h2>
        <p class="my-text-orange">توسعه دهنده بک اند و مدرس</p>
        <ul class="px-0 text-center">
            @foreach ($navbarItems as $navbarItem)
            <a href="{{ $navbarItem->route}}">
                <li class="nav-item {{ $navbarItem->route === url()->full() ? 'active' : '' }}">{{ $navbarItem->name }}
                </li>
            </a>
            @endforeach
        </ul>
        <p class="copyright">
            طراحی و توسعه با ❤️ و ☕ توسط تیم
            <a href="https://itadbeer.com/">آی تدبیر</a>
        </p>
    </footer>
    @endif
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/splide.min.js') }}"></script>
    <script src="{{ asset('assets/js/moovie.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}" defer></script>
</body>

</html>
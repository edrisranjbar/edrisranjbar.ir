<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ادریس رنجبر - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v=3') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/splide.min.css') }}">
</head>

<body>
    <header>
        <nav class="menu navbar navbar-expand-lg">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="float-right navbar-nav me-auto mb-2 mb-lg-0 w-100">
                    @foreach ($navbarItems as $navbarItem)
                    <li class="nav-item {{ $navbarItem->route === url()->full() ? 'active' : '' }}">
                        <a href="{{ $navbarItem->route}}">
                            {{ $navbarItem->name }}
                        </a>
                    </li>
                    @endforeach
                    <li class="ms-auto">
                        <ul class="menu-account-section">
                            <li class="p-relative">
                                <i
                                    class="button button-outline-primary fa fa-solid fa-cart-shopping my-text-primary icon"></i>
                                <span class="circle d-flex justify-content-center align-items-center">۰</span>
                            </li>
                            <li class="btn btn-lg button-primary">
                                ورود / عضویت
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    @yield('content')
    <footer>
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
        <p class="copyright">تمامی حقوق برای وب سایت ادریس رنجبر محفوظ می باشد.</p>
    </footer>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/splide.min.js"></script>
</body>

</html>
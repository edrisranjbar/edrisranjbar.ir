<!DOCTYPE html>
<html lang="fa">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'مدیریت')</title>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <link href="{{ asset('assets/css/fonts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2-override.css') }}" rel="stylesheet">
    <script>
        const webBaseUrl = "{{ url('/') }}";
        const apiBaseUrl = `${webBaseUrl}/api`;
    </script>
    @vite(['resources/js/app.js', 'resources/js/analytics-chart.js'])
    <!-- FavIcon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
</head>

<body id="page-top" dir="rtl">
    <div id="wrapper">
        @include('templates.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('templates.admin-nav')
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/admin/dynamic-lists.js') }}" defer></script>
    @yield('js')
</body>

</html>
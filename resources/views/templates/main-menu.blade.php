<nav class="navbar navbar-expand-md mt-2">
    <a class="navbar-brand me-5" href="{{ url('/') }}">
        <h1 class="h3 text-primary">ادریس رنجبر</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="background: none; border:none;">
        <i class="fa fa-bars text-light"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @foreach ($navbarItems as $navbarItem)
        <li class="nav-item {{ $navbarItem->route === url()->full() ? 'active' : '' }}">
            <a href="{{ url($navbarItem->route) }}">
                {{ $navbarItem->name }}
            </a>
        </li>
        @endforeach
    </ul>
    @auth
    <button class="btn btn-primary btn-w-icon">
        <i class="fa fa-solid fa-sign-in me-1"></i>
        ورود / عضویت
    </button>
    @else
    خوش آمدید
    @endauth
</nav>
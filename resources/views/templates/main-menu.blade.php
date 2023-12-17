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
    @auth('user')
    <div class="navbar-nav navbar-dark ms-auto">
        <div class="btn-group">
            <button class="btn btn-outline-primary dropdown-toggle" id="profileDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
                @if($user->profile_photo)
                <img src="{{ $user->profile_photo ? asset('storage/upload/' . $user->profile_photo) : asset('images/profile-placeholder.jpg') }}" alt="{{ $user->name }}" class="rounded-circle"
                    width="30" height="30" style="width: 30px; height: 30px;">
                @endif
                {{ $user->name }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                <li>
                    <a class="dropdown-item text-dark" href="{{ route('user.profile') }}">پروفایل کاربری</a>
                </li>
                <li>
                    <a class="dropdown-item text-dark" href="{{ route('user.tutorials') }}">دوره های من</a>
                </li>
                <li>
                    <a class="dropdown-item text-dark" href="{{ route('user.wishlist') }}">علاقه‌مندی ها</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item text-dark" href="{{ route('user.logout') }}">خروج</a>
                </li>
            </ul>
        </div>
    </div>
    @else
    <a class="btn btn-primary btn-w-icon" href="{{ route('user.login') }}">
        <i class="fa fa-solid fa-sign-in me-1"></i>
        ورود / عضویت
    </a>
    @endauth
</nav>
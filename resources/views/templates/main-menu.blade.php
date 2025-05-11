<nav class="menu">
    <div class="main-menu-items-wrapper">
        <a href="{{ url('/') }}">
            <span class="d-none">ادریس رنجبر</span>
            <img src="{{ asset('images/logo.svg') }}" alt="ادریس رنجبر - توسعه دهنده بک اند وب"
                style="height: 48px; width: auto;">
        </a>
        <ul class="mb-0">
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">خانه</a>
            </li>
            <li class="nav-item {{ request()->is('blog*') ? 'active' : '' }}">
                <a href="{{ url('/blog') }}">بلاگ</a>
            </li>
            <li class="nav-item {{ request()->is('podcasts*') ? 'active' : '' }}">
                <a href="{{ url('/podcasts') }}">پادکست</a>
            </li>
        </ul>
    </div>

    <div class="hamburger-menu-button cross menu--1">
        <label>
            <input type="checkbox">
            <svg onclick="toggleMenu();" viewBox="0 0 68 68" xmlns="http://www.w3.org/2000/svg" width="48px"
                height="48px">
                <path class="line--1" d="M0 40h62c13 0 6 28-4 18L35 35" />
                <path class="line--2" d="M0 50h70" />
                <path class="line--3" d="M0 60h62c13 0 6-28-4-18L35 65" />
            </svg>
        </label>
    </div>

    <div class="menu-buttons-wrapper">
        @auth('user')
        <div class="navbar-nav navbar-dark ms-auto">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ $user->profile_photo }}" alt="{{ $user->name }}" class="user-profile-photo">
                    {{ $user->name }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item text-dark" href="{{ route('user.profile') }}">پروفایل کاربری</a>
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
        <a class="button button-sm button-primary btn-w-icon" href="{{ route('user.login') }}">
            <i class="fa fa-solid fa-sign-in me-1"></i>
            ورود / عضویت
        </a>
        @endauth
    </div>
</nav>

<nav class="hamburger-menu-container" style="opacity: 0">
    <img src="{{ asset('images/logo.svg') }}" alt="ادریس رنجبر - توسعه دهنده بک اند وب"
        style="height: 48px; width: auto;">
    <div class="{{ request()->is('/') ? 'active' : '' }}">
        <a href="{{ url('/') }}">خانه</a>
    </div>
    <div class="{{ request()->is('blog*') ? 'active' : '' }}">
        <a href="{{ url('/blog') }}">بلاگ</a>
    </div>
    <div class="{{ request()->is('podcasts*') ? 'active' : '' }}">
        <a href="{{ url('/podcasts') }}">پادکست</a>
    </div>
    <div class="hamburger-menu-footer">
        @auth('user')
        <a class="btn btn-primary btn-w-icon" href="{{ route('user.profile') }}">
            <i class="fa fa-solid fa-user me-1"></i>
            پروفایل کاربری
        </a>
        @else
        <a class="btn btn-sm btn-primary btn-w-icon" href="{{ route('user.login') }}">
            <i class="fa fa-solid fa-sign-in me-1"></i>
            ورود / عضویت
        </a>
        @endauth
    </div>
</nav>
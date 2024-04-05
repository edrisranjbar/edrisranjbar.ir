<nav class="menu">
    <div class="main-menu-items-wrapper">
        <a href="{{ url('/') }}">
            <span class="d-none">ادریس رنجبر</span>
            <img src="{{ asset('images/logo.svg') }}" alt="ادریس رنجبر - توسعه دهنده بک اند وب"
                 style="height: 48px; width: auto;">
        </a>
        <ul class="mb-0">
            @foreach ($navbarItems as $navbarItem)
                <li class="nav-item {{ $navbarItem->route === url()->full() ? 'active' : '' }}">
                    <a href="{{ url($navbarItem->route) }}">
                        {{ $navbarItem->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="hamburger-menu-button cross menu--1">
        <label>
            <input type="checkbox">
            <svg onclick="toggleMenu();" viewBox="0 0 68 68" xmlns="http://www.w3.org/2000/svg"
                 width="48px" height="48px">
                <!--<circle cx="34" cy="34" r="30"/>-->
                <path class="line--1" d="M0 40h62c13 0 6 28-4 18L35 35"/>
                <path class="line--2" d="M0 50h70"/>
                <path class="line--3" d="M0 60h62c13 0 6-28-4-18L35 65"/>
            </svg>
        </label>
    </div>

    <div class="menu-buttons-wrapper">
        @auth('user')
            <div class="navbar-nav navbar-dark ms-auto">
                <div class="btn-group">
                    <button class="btn btn-outline-primary dropdown-toggle" id="profileDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        @if($user->profile_photo)
                            <img src="{{ $user->profile_photo_src}}"
                                 alt="{{ $user->name }}" class="user-profile-photo">
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
    </div>
</nav>

<nav class="hamburger-menu-container" style="opacity: 0">
    <img src="{{ asset('images/logo.svg') }}" alt="ادریس رنجبر - توسعه دهنده بک اند وب"
         style="height: 48px; width: auto;">
    @foreach ($navbarItems as $navbarItem)
        <div class="{{ $navbarItem->route === url()->full() ? 'active' : '' }}">
            <a href="{{ url($navbarItem->route) }}">
                {{ $navbarItem->name }}
            </a>
        </div>
    @endforeach
    <div class="hamburger-menu-footer">
        @auth('user')
            <a class="btn btn-primary btn-w-icon" href="{{ route('user.profile') }}">
                <i class="fa fa-solid fa-user me-1"></i>
                پروفایل کاربری
            </a>
        @else
            <a class="btn btn-sm btn-dark btn-w-icon" href="{{ route('user.login') }}">
                <i class="fa fa-solid fa-sign-in me-1"></i>
                ورود / عضویت
            </a>
        @endauth
    </div>
</nav>
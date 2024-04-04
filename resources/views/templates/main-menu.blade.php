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
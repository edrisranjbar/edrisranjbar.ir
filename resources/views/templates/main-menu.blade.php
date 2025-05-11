<nav class="menu">
    <div class="main-menu-items-wrapper">
        <a href="{{ url('/') }}">
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
            <li class="nav-item">
                <a href="https://www.youtube.com/@EdiCodes" target="_blank" rel="noopener noreferrer">ویدیو ها</a>
            </li>
            <li class="nav-item {{ request()->is('donate*') ? 'active' : '' }}">
                <a href="{{ url('/donate') }}">حمایت مالی</a>
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
    <div>
        <a href="https://www.youtube.com/@EdiCodes" target="_blank" rel="noopener noreferrer">ویدیو ها</a>
    </div>
    <div class="{{ request()->is('donate*') ? 'active' : '' }}">
        <a href="{{ url('/donate') }}">حمایت مالی</a>
    </div>
</nav>
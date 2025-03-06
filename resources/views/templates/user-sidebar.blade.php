<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion"
    id="accordionSidebar">

    <li class="d-flex d-md-block align-items-center justify-content-between">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('user') }}">
            <div class="sidebar-brand-text mx-3">
                پنل دانش آموزان
            </div>
        </a>
        <button id="sidebar-dismiss-button" class="btn btn-close me-3 btn-close-white d-md-none">
        </button>
    </li>

    <li>
        <hr class="sidebar-divider my-0">
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('user') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>داشبورد</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.tutorials') }}">
            <i class="fas fa-fw fa-film"></i>
            <span>دوره های من</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.wishlist') }}">
            <i class="fas fa-fw fa-heart"></i>
            <span>علاقه مندی ها</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>حساب کاربری</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-arrow-right"></i>
            برگشتن به سایت
        </a>
    </li>

</ul>
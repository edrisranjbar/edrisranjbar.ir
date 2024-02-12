<ul class="m-0 p-0 navbar-nav sidebar sidebar-dark text-right"
    id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <li class="d-flex d-md-block align-items-center justify-content-between">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('user') }}">
            <div class="sidebar-brand-text mx-3">
                پنل دانش آموزان
            </div>
        </a>
        <button id="sidebar-dismiss-button" class="btn btn-close me-3 btn-close-white d-md-none">
        </button>
    </li>

    <!-- Divider -->
    <li>
        <hr class="sidebar-divider my-0">
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('user') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>داشبورد</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.tutorials') }}">
            <i class="fas fa-fw fa-pen"></i>
            <span>دوره های من</span>
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
<!-- End of Sidebar -->
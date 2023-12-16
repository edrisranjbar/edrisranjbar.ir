<!-- Sidebar -->
<ul class="m-0 p-0 navbar-nav bg-dark sidebar sidebar-dark accordion text-right rounded-top-right-1 rounded-bottom-right-1"
    id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <li>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('user') }}">
            <div class="sidebar-brand-text mx-3">
                پنل دانش آموزان
            </div>
        </a>
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

</ul>
<!-- End of Sidebar -->
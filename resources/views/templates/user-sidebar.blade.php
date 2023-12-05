<!-- Sidebar -->
<ul class="m-0 p-0 navbar-nav bg-dark sidebar sidebar-dark accordion text-right rounded-top-right-1 rounded-bottom-right-1"
    id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <li>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('admin') }}">
            <div class="sidebar-brand-text mx-3">
                مدیریت
            </div>
        </a>
    </li>

    <!-- Divider -->
    <li>
        <hr class="sidebar-divider my-0">
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>داشبورد</span>
        </a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapsePosts"
            aria-expanded="false" aria-controls="collapsePosts">
            <i class="fas fa-fw fa-pen"></i>
            <span>دوره های من</span>
        </a>
        <div id="collapsePosts" class="collapse" aria-labelledby="collapsePosts" data-parent="#accordionSidebar">
            <div class="collapse-inner">
                <a class="collapse-item" href="{{ route('posts.index') }}">
                    <span>لیست نوشته ها</span>
                </a>
                <a class="collapse-item" href="{{ route('posts.create') }}">
                    <span>ایجاد نوشته</span>
                </a>
                <a href="{{ route('categories.index') }}" class="collapse-item">
                    دسته بندی ها
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/settings') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>حساب کاربری</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
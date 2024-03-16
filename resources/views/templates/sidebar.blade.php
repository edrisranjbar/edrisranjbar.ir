<ul class="m-0 p-0 navbar-nav bg-gradient-primary sidebar sidebar-dark text-right"
    id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <li class="d-flex d-md-block align-items-center justify-content-between">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('admin') }}">
            <div class="sidebar-brand-text mx-3">
                مدیریت
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
        <a class="nav-link" href="{{ url('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>داشبورد</span>
        </a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapsePosts"
            aria-expanded="false" aria-controls="collapsePosts">
            <i class="fas fa-fw fa-pen"></i>
            <span>نوشته ها</span>
        </a>
        <div id="collapsePosts" class="collapse" aria-labelledby="collapsePosts" data-parent="#accordionSidebar">
            <div class="collapse-inner">
                <a class="collapse-item" href="{{ route('posts.index') }}">
                    <span>لیست نوشته ها</span>
                </a>
                <a href="{{ route('categories.index') }}" class="collapse-item">
                    دسته بندی ها
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapsePages"
            aria-expanded="false" aria-controls="collapsePages">
            <i class="fas fa-fw fa-file"></i>
            <span>برگه ها</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="collapsePages" data-parent="#accordionSidebar">
            <div class="collapse-inner">
                <a class="collapse-item" href="{{ route('pages.index') }}">
                    <span>لیست برگه ها</span>
                </a>
                <a class="collapse-item" href="{{ route('pages.create') }}">
                    <span>ایجاد برگه</span>
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTutorials"
            aria-expanded="false" aria-controls="collapseTutorials">
            <i class="fas fa-fw fa-book"></i>
            <span>دوره های آموزشی</span>
        </a>
        <div id="collapseTutorials" class="collapse" aria-labelledby="collapseTutorials"
            data-parent="#accordionSidebar">
            <div class="collapse-inner">
                <a class="collapse-item" href="{{ route('tutorials.index') }}">
                    <span>لیست دوره ها</span>
                </a>
                <a class="collapse-item" href="{{ route('lessons.index') }}">
                    <span>درس ها</span>
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/settings') }}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>تنظیمات</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
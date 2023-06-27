<!-- Sidebar -->
<ul class="m-0 p-0 navbar-nav bg-dark sidebar sidebar-dark accordion text-right rounded-top-right-1 rounded-bottom-right-1"
    id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <li>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="http://127.0.0.1:8000/admin">
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
            <span>نوشته ها</span>
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
        <a class="nav-link dropdown-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapsePortfolio"
            aria-expanded="false" aria-controls="collapsePortfolio">
            <i class="fas fa-fw fa-images"></i>
            <span>نمونه کار ها</span>
        </a>
        <div id="collapsePortfolio" class="collapse" aria-labelledby="collapsePortfolio"
            data-parent="#accordionSidebar">
            <div class="collapse-inner">
                <a class="collapse-item" href="">
                    <span>لیست نمونه کار ها</span>
                </a>
                <a class="collapse-item" href="">
                    <span>ایجاد نمونه کار</span>
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
                <a class="collapse-item" href="">
                    <span>لیست دوره ها</span>
                </a>
                <a class="collapse-item" href="">
                    <span>ایجاد دوره</span>
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapseLoan"
            aria-expanded="false" aria-controls="collapseLoan">
            <i class="fas fa-fw fa-microphone"></i>
            <span>پادکست</span>
        </a>
        <div id="collapseLoan" class="collapse" aria-labelledby="collapseLoan" data-parent="#accordionSidebar">
            <div class="collapse-inner">
                <a class="collapse-item" href="">لیست اپیزود ها</a>
                <a class="collapse-item" href="">افزودن اپیزود جدید</a>
            </div>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTools"
            aria-expanded="false" aria-controls="collapseTools">
            <i class="fas fa-fw fa-tools"></i>
            <span>ابزارها</span>
        </a>
        <div id="collapseTools" class="collapse" aria-labelledby="collapseTools" data-parent="#accordionSidebar">
            <div class="collapse-inner">
                <a class="collapse-item" href="http://127.0.0.1:8000/admin/notes">یادداشت‌ها</a>
                <a class="collapse-item" href="http://127.0.0.1:8000/admin/backups">پشتیبان‌گیری</a>
            </div>
        </div>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="http://127.0.0.1:8000/admin/settings">
            <i class="fas fa-fw fa-wrench"></i>
            <span>تنظیمات</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
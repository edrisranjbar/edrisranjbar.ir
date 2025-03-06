<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('admin') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">داشبورد</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>داشبورد</span>
        </a>
    </li>

    <!-- Nav Item - Posts -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePosts" aria-expanded="true"
            aria-controls="collapsePosts">
            <i class="fas fa-fw fa-pen"></i>
            <span>نوشته ها</span>
        </a>
        <div id="collapsePosts" class="collapse" aria-labelledby="headingPosts" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('posts.index') }}">لیست نوشته ها</a>
                <a class="collapse-item" href="{{ route('categories.index') }}">دسته بندی ها</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Tutorials -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTutorials"
            aria-expanded="true" aria-controls="collapseTutorials">
            <i class="fas fa-fw fa-book"></i>
            <span>دوره های آموزشی</span>
        </a>
        <div id="collapseTutorials" class="collapse" aria-labelledby="headingTutorials" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('tutorials.index') }}">لیست دوره ها</a>
                <a class="collapse-item" href="{{ route('lessons.index') }}">درس ها</a>
                <a class="collapse-item" href="{{ route('students.index') }}">دانشجویان</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Contact Forms -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/contactForms') }}">
            <i class="fas fa-envelope"></i>
            <span>فرم‌های ارتباط با ما</span>
        </a>
    </li>

    <!-- Nav Item - Comments -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/comments') }}">
            <i class="fas fa-fw fa-comment"></i>
            <span>دیدگاه‌ها</span>
        </a>
    </li>

    <!-- Nav Item - Analytics -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/analytics') }}">
            <i class="fas fa-fw fa-chart-pie"></i>
            <span>آمار</span>
        </a>
    </li>

    <!-- Nav Item - Settings -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/settings') }}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>تنظیمات</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
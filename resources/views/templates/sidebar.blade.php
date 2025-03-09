<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>داشبورد</span>
        </a>
    </li>

    <!-- Nav Item - Posts -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePosts"
            aria-expanded="false" aria-controls="collapsePosts">
            <i class="fas fa-fw fa-pen"></i>
            <span>نوشته ها</span>
        </a>
        <div id="collapsePosts" class="collapse" aria-labelledby="headingPosts" data-bs-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('posts.index') }}">لیست نوشته ها</a>
                <a class="collapse-item" href="{{ route('categories.index') }}">دسته بندی ها</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Tutorials -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTutorials"
            aria-expanded="false" aria-controls="collapseTutorials">
            <i class="fas fa-fw fa-book"></i>
            <span>دوره های آموزشی</span>
        </a>
        <div id="collapseTutorials" class="collapse" aria-labelledby="headingTutorials"
            data-bs-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
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

</ul>
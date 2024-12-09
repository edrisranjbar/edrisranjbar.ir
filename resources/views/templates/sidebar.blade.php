<ul class="m-3 p-0 navbar-nav bg-black sidebar sidebar-dark text-right px-2" id="accordionSidebar">

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
                <a class="collapse-item" href="{{ route('students.index') }}">
                    <span>دانشجویان</span>
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/contactForms') }}">
            <i class="fas fa-envelope"></i>
            <span>فرم‌های ارتباط با ما</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/comments') }}">
            <i class="fas fa-fw fa-comment"></i>
            <span>دیدگاه‌ها</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/analytics') }}">
            <i class="fas fa-fw fa-chart-pie"></i>
            <span>آمار</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/settings') }}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>تنظیمات</span>
        </a>
    </li>
</ul>
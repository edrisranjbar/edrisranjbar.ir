<section class="hero row">
    <div class="profile-section col-12 col-lg-6">
        <img src="{{ $widgets['hero']['image']['src'] }}" alt="{{ $widgets['hero']['image']['alt'] }}" class="profile">
        <div class="circle-sm my-bg-primary rounded-circle left-top"></div>
        <div class="circle-sm bg-orange rounded-circle right-top"></div>
        <div class="circle-md bg-orange rounded-circle right-bottom"></div>
    </div>
    <div class="hero-details-section col-12 col-lg-6">
        <p class="hero-subtitle">{{ $widgets['hero']['subtitle'] }}</p>
        <p class="hero-title">{!! $widgets['hero']['title'] !!}</p>
        <p class="hero-description">{!! $widgets['hero']['description'] !!}</p>
        <div class="d-flex gap-2 text-light justify-content-center justify-content-lg-start">
            <a class="button button-primary btn-w-icon" href="{{ $coursesUrl }}">
                <i class="fa-solid fa-person-chalkboard me-1"></i>
                مشاهده دوره ها
            </a>
            <a class="button button-outline-white" href="{{ $blogUrl }}">وبلاگ</a>
        </div>
    </div>
</section>
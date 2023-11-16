<section id="blog" class="row">
    <div class="col-12 col-xl-6 blog-left">
        <h2 class="title">جدیدترین نوشته ها</h2>
        <div class="breaker"></div>
        <p class="blog-section-description">این یک متن تستیه، این یک متن تستیه، این یک متن تستیه، این یک
            متن تستیه، این یک متن تستیه...</p>
        <a href="#" class="btn btn-lg btn-outline-primary text-light d-inline-block btn-w-icon">
            <i class="fa fa-eye me-1"></i>
            مشاهده همه
        </a>
    </div>
    <div class="col-12 col-xl-6 splide blog-right" role="group" aria-label="اسلایدر نوشته ها">
        <div class="splide__track">
            <ul class="splide__list">
                @forelse($posts as $post)
                <li class="card blog splide__slide">
                    <a href="{{ $post->link }}">
                        <img src="{{ asset('storage/upload/' . $post->thumbnail) }}" class="thumbnail"
                            alt="{{ $post->title }}">
                    </a>
                    <h3 class="post-title">{{ $post->title }}</h3>
                    <div class="d-flex post-meta">
                        <a href="{{ $post->link }}" class="btn btn-sm text-light btn-primary btn-w-icon">
                            <i class="fa fa-solid fa-eye me-1"></i>
                            مشاهده
                        </a>
                    </div>
                </li>
                @empty
                <li class="card blog splide__slide w-100 m-0">
                    <img src="{{ asset('images/empty.svg') }}">
                    <p class="w-100 text-center">نوشته ای یافت نشد</p>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</section>
<section id="blog" class="row">
    <div class="col-12 col-xl-6 blog-left">
        <h2 class="title">جدیدترین نوشته ها</h2>
        <div class="breaker"></div>
        <p class="blog-section-description">این یک متن تستیه، این یک متن تستیه، این یک متن تستیه، این یک
            متن تستیه، این یک متن تستیه...</p>
    </div>
    <div class="col-12 col-xl-6 splide blog-right" role="group" aria-label="اسلایدر نوشته ها">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach($posts as $post)
                <li class="card blog splide__slide">
                    <a href="{{ $post->link }}">
                        <img src="{{ asset('storage/upload/' . $post->thumbnail) }}" class="thumbnail"
                            alt="{{ $post->title }}">
                    </a>
                    <h3 class="post-title">{{ $post->title }}</h3>
                    <div class="d-flex post-meta">
                        <a href="{{ $post->link }}" class="btn btn-sm btn-primary">مشاهده</a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
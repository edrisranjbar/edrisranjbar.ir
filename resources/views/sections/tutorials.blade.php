<section id="tutorials" class="row">
    <div class="tutorials-left col-xl-6 col-12">
        <h2 class="title">دوره های آموزشی</h2>
        <div class="breaker"></div>
        <p class="tutorials-section-description">
            من توی دوره های آموزشیم سعی میکنم مفاهیم و مهارت ها رو به صورت واضح و ساده بیان کنم. تا جای ممکن هم
            پروژه محور پیش میریم که براتون کاربردی باشه.
        </p>
        <a href="#" class="btn btn-lg btn-outline-primary text-light d-inline-block btn-w-icon">
            <i class="fa fa-eye me-1"></i>
            مشاهده همه
        </a>
    </div>
    <div class="col-12 col-xl-6 splide tutorials-right" role="group" aria-label="اسلایدر دوره ها">
        <div class="splide__track">
            <ul class="splide__list">
                @forelse($tutorials as $tutorial)
                <li class="card tutorial splide__slide">
                    <a href="{{ $tutorial->link }}">
                        @if ($tutorial->thumbnail)
                        <img src="{{ asset('storage/upload/' . $tutorial->thumbnail) }}" class="thumbnail"
                            alt="{{ $tutorial->title }}">
                        @endif
                        <h3 class="post-title">{{ $tutorial->title }}</h3>
                    </a>
                    <div class="d-flex post-meta">
                        <a href="{{ $tutorial->link }}" class="btn btn-sm btn-outline-primary btn-w-icon">
                            <i class="fa fa-solid fa-eye me-1"></i>
                            مشاهده
                        </a>
                        <div class="d-flex align-items-center students-count">
                            <i class="fas fa-user-circle"></i>
                            دانشجویان: {{ $tutorial->students()->count() }}
                        </div>
                    </div>
                </li>
                @empty
                <li class="card tutorial splide__slide w-100 m-0">
                    <img src="{{ asset('images/empty.svg') }}">
                    <p class="w-100 text-center">دوره ای یافت نشد</p>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</section>
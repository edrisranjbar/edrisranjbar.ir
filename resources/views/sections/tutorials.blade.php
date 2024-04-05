<section id="tutorials" class="row">
    <div class="tutorials-left col-xl-6 col-12">
        <h2 class="title">دوره های آموزشی</h2>
        <div class="breaker"></div>
        <p class="tutorials-section-description">
            من توی دوره های آموزشیم سعی میکنم مفاهیم و مهارت ها رو به صورت واضح و ساده بیان کنم. تا جای ممکن هم
            پروژه محور پیش میریم که براتون کاربردی باشه.
        </p>
        <a href="{{ $coursesUrl }}"
           class="button button-sm button-outline-primary d-inline-block btn-w-icon">
            <i class="fa fa-eye me-1"></i>
            مشاهده همه
        </a>
    </div>
    <div class="col-12 col-xl-6 splide tutorials-right" role="group" aria-label="اسلایدر دوره ها">
        <div class="splide__track">
            <ul class="splide__list">
                @forelse($tutorials as $tutorial)
                    <div class="card tutorial splide__slide">
                        <a href="{{ $tutorial->link }}">
                            @if ($tutorial->thumbnail)
                                <img src="{{ asset('storage/upload/' . $tutorial->thumbnail) }}"
                                     class="card-img-top" alt="{{ $tutorial->title }}">
                            @endif
                        </a>
                        <div class="card-body w-100">
                            <a href="{{ $tutorial->link }}">
                                <h3 class="card-title h4">{{ $tutorial->title }}</h3>
                            </a>
                            <p class="card-text">{{ $tutorial->excerpt }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ $tutorial->link }}"
                                   class="button button-sm text-dark button-outline-primary btn-w-icon">
                                    <i class="fa fa-solid fa-eye me-1"></i>
                                    مشاهده دوره
                                </a>
                                <div class="d-flex align-items-center students-count">
                                    {{ $tutorial->priceLabel }}
                                </div>
                            </div>
                        </div>
                    </div>
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
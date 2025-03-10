@section('title', $tutorial->title)
@section('header-class', 'bg-dark')
@extends('layouts.app')
@section('content')
<main>
    <div class="hero-section row align-items-center w-100 mx-0">
        <div class="col-12 col-md-8">
            <span class="breadcrumb">
                <a href="{{ url('tutorials') }}">دوره های آموزشی</a>&nbsp;»&nbsp;
                <a href="#">برنامه نویسی</a>
            </span>
            <h1 class="tutorial-title display-3">
                {{ $tutorial->title }}
            </h1>
            <p class="tutorial-short-description fs-4">
                {{ $tutorial->short_description }}
            </p>
            <div class="d-flex tutorial-action-buttons mb-4 mb-md-0">
                <form action="{{ route('tutorials.enroll', ['slug' => $tutorial->id]) }}" method="post">
                    @csrf
                    @if(!$userHasEnrolled)
                    <button type="submit" class="button button-secondary">همین حالا شروع کن!</button>
                    @else
                    <a class="button button-secondary" href="{{ url("tutorials/" . $tutorial->slug . "/lessons/" .
                        $tutorial->lessons?->first()->id) }}">شروع
                        درس ها</a>
                    @endif
                </form>
                <form action="{{ route('wishlist.addOrRemove', ['id' => $tutorial->id]) }}" method="POST">
                    @csrf
                    @if (!$tutorial->isInWishlist())
                    <button type="submit" class="button button-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path
                                d="M20.8594 3.75C18.4395 3.75 16.3207 4.79062 15 6.54961C13.6793 4.79062 11.5605 3.75 9.14062 3.75C7.21433 3.75217 5.36755 4.51835 4.00545 5.88045C2.64335 7.24255 1.87717 9.08933 1.875 11.0156C1.875 19.2187 14.0379 25.8586 14.5559 26.1328C14.6924 26.2063 14.845 26.2447 15 26.2447C15.155 26.2447 15.3076 26.2063 15.4441 26.1328C15.9621 25.8586 28.125 19.2187 28.125 11.0156C28.1228 9.08933 27.3566 7.24255 25.9945 5.88045C24.6325 4.51835 22.7857 3.75217 20.8594 3.75ZM15 24.2344C12.8602 22.9875 3.75 17.3074 3.75 11.0156C3.75186 9.58651 4.3204 8.21647 5.33093 7.20593C6.34147 6.1954 7.71151 5.62686 9.14062 5.625C11.4199 5.625 13.3336 6.83906 14.1328 8.78906C14.2034 8.96101 14.3236 9.10808 14.478 9.21158C14.6324 9.31508 14.8141 9.37034 15 9.37034C15.1859 9.37034 15.3676 9.31508 15.522 9.21158C15.6764 9.10808 15.7966 8.96101 15.8672 8.78906C16.6664 6.83555 18.5801 5.625 20.8594 5.625C22.2885 5.62686 23.6585 6.1954 24.6691 7.20593C25.6796 8.21647 26.2481 9.58651 26.25 11.0156C26.25 17.298 17.1375 22.9863 15 24.2344Z"
                                fill="#FEDB80" />
                        </svg>
                    </button>
                    @else
                    <button type="submit" class="button button-outline-secondary">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20.8594 3.75C18.4395 3.75 16.3207 4.79062 15 6.54961C13.6793 4.79062 11.5605 3.75 9.14062 3.75C7.21433 3.75217 5.36755 4.51835 4.00545 5.88045C2.64335 7.24255 1.87717 9.08933 1.875 11.0156C1.875 19.2187 14.0379 25.8586 14.5559 26.1328C14.6924 26.2063 14.845 26.2447 15 26.2447C15.155 26.2447 15.3076 26.2063 15.4441 26.1328C15.9621 25.8586 28.125 19.2187 28.125 11.0156C28.1228 9.08933 27.3566 7.24255 25.9946 5.88045C24.6325 4.51835 22.7857 3.75217 20.8594 3.75Z"
                                fill="#FF0000" />
                        </svg>
                    </button>
                    @endif
                </form>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="d-flex flex-column tutorial-attributes-section">
                <div class="tutorial-attribute">
                    <img src="{{ asset('assets/icons/coins.png') }}" alt="هزینه">
                    <span>شهریه دوره: {{ $tutorial->priceLabel }}</span>
                </div>
                <div class="tutorial-attribute">
                    <img src="{{ asset('images/duration-icon.png') }}" alt="طول دوره">
                    <span>طول دوره:
                        {{ $tutorial->getTotalDurationHumanReadable() }}
                    </span>
                </div>
                <div class="tutorial-attribute">
                    <img src="{{ asset('images/counter-icon.png') }}" alt="تعداد جلسات دوره">
                    <span>تعداد جلسات: {{ $tutorial->lessons->count() }} جلسه</span>
                </div>
            </div>
        </div>
    </div>

    <div class="tutorial-content">
        <div class="video-player-container">
            <img src="https://i.stack.imgur.com/zZNgk.png">
            <video
                src="{{ $tutorial->lessons?->first() ? asset('storage/upload/' . $tutorial->lessons?->first()->video_path) : "" }}"
                class="video-player"
                poster="{{ $tutorial->lessons?->first() ? asset('storage/upload/' . $tutorial->lessons?->first()->thumbnail) : "" }}"
                controls></video>
        </div>
        <p class="video-caption">{{ $tutorial->lessons->first()?->title }}</p>
        <br>
        <p class="about-tutorial-title display-5">درباره دوره {{ $tutorial?->title }}</p>
        <span class="tutorial-description">
            {!! $tutorial->description !!}
            @if($tutorial->price === 0)
            <br>
            @include('templates.donate')
            @endif
        </span>
        <br><br>
    </div>
    @if(count($tutorial->getGoodForItems()) > 0 && $tutorial->getGoodForItems()[0])
    <div class="good-bad-section">
        <div class="good-or-bad-box first">
            <div class="tutorial-is-good-for">
                <img src="{{asset('images/thumbs-up.png') }}" class="thumbs-up">
                <p>این دوره
                    برای چه کسانی
                    <span style="color: #66AD7E;">مناسـب</span>
                    اسـت؟
                </p>
            </div>
            <div class="tutorial-is-good-for-content">
                <p>
                    @foreach($tutorial->getGoodForItems() ?? [] as $item)
                    <span class="text-success">
                        ✓
                    </span>
                    {{ $item }}
                    <br>
                    @endforeach
                </p>
            </div>
        </div>
        @endif
        @if(count($tutorial->getBadForItems()) > 0 && $tutorial->getBadForItems()[0])
        <div class="good-or-bad-box last">
            <div class="tutorial-is-bad-for">
                <img src="{{asset('images/thumbs-down.png') }}" class="thumbs-down">
                <p>این دوره برای چه کسانی مناسـب<span style="color: #FF5757;">نیست</span>؟</p>
            </div>
            <div class="tutorial-is-bad-for-content">
                @foreach($tutorial->getBadForItems() ?? [] as $item)
                <span class="text-danger">✖</span>
                {{ $item }}
                <br>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div id="tutorial-syllabus">
        <h2 class="tutorial-syllabus-title display-5">« سرفصلهای دوره »</h2>
        <section class="accordion">
            @foreach($tutorial->sections as $section)
            <div class="accordion-header" id="accordion-{{ $loop->iteration }}">
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row align-items-center">
                        <svg class="accordion-burger-icon" width="38" height="34" viewBox="0 0 38 34" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path id="Vector"
                                d="M34.3332 27.5416C35.0715 27.5419 35.7814 27.8264 36.3157 28.3359C36.8501 28.8454 37.1679 29.5409 37.2034 30.2784C37.2389 31.0159 36.9893 31.7388 36.5063 32.2972C36.0234 32.8557 35.3441 33.2069 34.6092 33.2782L34.3332 33.2916H3.6665C2.92817 33.2912 2.21828 33.0068 1.68393 32.4973C1.14958 31.9878 0.831731 31.2922 0.796249 30.5547C0.760767 29.8173 1.01037 29.0944 1.49334 28.5359C1.97631 27.9775 2.65562 27.6262 3.3905 27.555L3.6665 27.5416H34.3332ZM34.3332 14.1249C35.0957 14.1249 35.8269 14.4278 36.3661 14.967C36.9053 15.5062 37.2082 16.2374 37.2082 16.9999C37.2082 17.7624 36.9053 18.4937 36.3661 19.0329C35.8269 19.572 35.0957 19.8749 34.3332 19.8749H3.6665C2.90401 19.8749 2.17274 19.572 1.63357 19.0329C1.0944 18.4937 0.791504 17.7624 0.791504 16.9999C0.791504 16.2374 1.0944 15.5062 1.63357 14.967C2.17274 14.4278 2.90401 14.1249 3.6665 14.1249H34.3332ZM34.3332 0.708252C35.0957 0.708252 35.8269 1.01115 36.3661 1.55032C36.9053 2.08949 37.2082 2.82075 37.2082 3.58325C37.2082 4.34575 36.9053 5.07702 36.3661 5.61618C35.8269 6.15535 35.0957 6.45825 34.3332 6.45825H3.6665C2.90401 6.45825 2.17274 6.15535 1.63357 5.61618C1.0944 5.07702 0.791504 4.34575 0.791504 3.58325C0.791504 2.82075 1.0944 2.08949 1.63357 1.55032C2.17274 1.01115 2.90401 0.708252 3.6665 0.708252H34.3332Z"
                                fill="black" />
                        </svg>
                        <h3 class="accordion-title fs-4">{{ $section->title }}</h3>
                    </div>
                    <img src="{{ asset('assets/icons/plus-circle.svg') }}" class="accordion-arrow">
                </div>
            </div>
            <div class="accordion-body" id="accordion-{{ $loop->iteration }}-body">
                @foreach($section->lessons as $lesson)
                <li class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="lesson-counter-label fs-5">
                            جلسه {{ $loop->iteration }}:
                        </span>
                        <span class="lesson-title fs-5">{{ $lesson->title }}</span>
                    </div>
                    <span class="lesson-duration">{{ $lesson->getDurationHumanReadable() }}</span>
                </li>
                @endforeach
            </div>
            @endforeach
        </section>
    </div>

    <section class="tutorial-attributes">
        <div class="background"></div>
        <h2 class="tutorial-attributes-title display-5">« ویژگی های دوره »</h2>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="attribute-card">
                    <div class="content">
                        <img class="tutorial-attribute-thumbnail" src="{{ asset('images/code.png') }}" alt="">
                        <div class="d-flex flex-column">
                            <h3 class="tutorial-attribute-title">پروژه محور</h3>
                            <p class="tutorial-attribute-description">
                                در این دوره سعی شده آموزش و تمارین کاربردی و مربوط به دنیای واقعی باشه.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="attribute-card">
                    <div class="content">
                        <img class="tutorial-attribute-thumbnail" src="{{ asset('images/practice.png') }}" alt="">
                        <div class="d-flex flex-column">
                            <h3 class="tutorial-attribute-title">تمرین حل مسئله</h3>
                            <p class="tutorial-attribute-description">
                                هر چی تمرین واقعی تر باشه وقت و انرژی و خلاقیتی که برای حل کردنش میزاری بیشتر و
                                بهینه تر
                                میشه.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="attribute-card h-100">
                    <div class="content">
                        <div class="d-flex flex-column">
                            <img class="tutorial-attribute-thumbnail mx-auto" src="{{ asset('images/quiality.png') }}"
                                alt="" style="margin-bottom: 16px;">
                            <h3 class="tutorial-attribute-title text-center">تمرین حل مسئله</h3>
                            <p class="tutorial-attribute-description text-center">
                                هر چی تمرین واقعی تر باشه وقت و انرژی و خلاقیتی که برای حل کردنش میزاری بیشتر و
                                بهینه تر
                                میشه.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container-lg" id="tutorial-tutor">
        <img src="{{ asset('images/profile-transparent.png') }}" alt="" class="tutor-profile">
        <div>
            <h2>« درباره مدرس دوره »</h2>
            <p>
                ســــلــااام✋ من ادریس رنجبر هستم، یه عدد برنامه نویس یا به عبارت دقیق تر، توسعه دهنده بک اند
                وب.
                کار اصلیم ساخت و توسعه
                وب سایت و وب اپلیکیشینه و در کنارش آموزش هم میدم. خیلی وقت ها به صورت فریلنسری و فول استک کار
                میکنم.
                بیشتر وقتم را در
                دنیای کدنویسی و طراحی وب سپری می‌کنم. علاقه‌مند به به اشتراک گذاری تجربیات و مهارت‌هایم هستم و
                همیشه
                در تلاش برای
                یادگیری و بهبود خودم هستم.
            </p>
            <div class="d-flex column-gap-2 tutorial-tutor-button-group">
                <button class="button button-secondary">
                    <svg style="margin-left: 8px;" xmlns="http://www.w3.org/2000/svg" width="33" height="30"
                        viewBox="0 0 33 30" fill="none">
                        <path
                            d="M25.5275 26.25C25.5275 25.9115 25.4057 25.6185 25.1621 25.3711C24.9185 25.1237 24.6301 25 24.2967 25C23.9634 25 23.6749 25.1237 23.4313 25.3711C23.1878 25.6185 23.066 25.9115 23.066 26.25C23.066 26.5885 23.1878 26.8815 23.4313 27.1289C23.6749 27.3763 23.9634 27.5 24.2967 27.5C24.6301 27.5 24.9185 27.3763 25.1621 27.1289C25.4057 26.8815 25.5275 26.5885 25.5275 26.25ZM30.4506 26.25C30.4506 25.9115 30.3288 25.6185 30.0852 25.3711C29.8416 25.1237 29.5531 25 29.2198 25C28.8865 25 28.598 25.1237 28.3544 25.3711C28.1108 25.6185 27.989 25.9115 27.989 26.25C27.989 26.5885 28.1108 26.8815 28.3544 27.1289C28.598 27.3763 28.8865 27.5 29.2198 27.5C29.5531 27.5 29.8416 27.3763 30.0852 27.1289C30.3288 26.8815 30.4506 26.5885 30.4506 26.25ZM32.9121 21.875V28.125C32.9121 28.6458 32.7326 29.0885 32.3736 29.4531C32.0147 29.8177 31.5788 30 31.066 30H2.75826C2.24544 30 1.80955 29.8177 1.45057 29.4531C1.0916 29.0885 0.912109 28.6458 0.912109 28.125V21.875C0.912109 21.3542 1.0916 20.9115 1.45057 20.5469C1.80955 20.1823 2.24544 20 2.75826 20H11.7006L14.2967 22.6562C15.0403 23.3854 15.9121 23.75 16.9121 23.75C17.9121 23.75 18.7839 23.3854 19.5275 22.6562L22.1429 20H31.066C31.5788 20 32.0147 20.1823 32.3736 20.5469C32.7326 20.9115 32.9121 21.3542 32.9121 21.875ZM26.6621 10.7617C26.8801 11.2956 26.7903 11.7513 26.3929 12.1289L17.7775 20.8789C17.5467 21.1263 17.2583 21.25 16.9121 21.25C16.566 21.25 16.2775 21.1263 16.0467 20.8789L7.43134 12.1289C7.0339 11.7513 6.94416 11.2956 7.16211 10.7617C7.38006 10.2539 7.75826 10 8.29673 10H13.2198V1.25C13.2198 0.911458 13.3416 0.61849 13.5852 0.371094C13.8288 0.123698 14.1172 0 14.4506 0H19.3736C19.707 0 19.9954 0.123698 20.239 0.371094C20.4826 0.61849 20.6044 0.911458 20.6044 1.25V10H25.5275C26.066 10 26.4442 10.2539 26.6621 10.7617Z"
                            fill="#353535" />
                    </svg>
                    دانلود رزومه
                </button>
                <button class="button button-outline-secondary">
                    رفتن به لینکدین
                </button>
            </div>
        </div>
    </section>

    <section id="tutorial-overview">
        <img src="{{ $tutorial->poster ? asset('storage/upload/' . $tutorial->poster) : asset('images/poster.png') }}"
            alt="{{ $tutorial->title }}" class="tutorial-poster">
        <div>
            <p class="tutorial-overview-title display-5">
                {{ $tutorial->title }}
            </p>
            <p class="tutorial-overview-description">
                {{ $tutorial->short_description }}
            </p>
            <div class="d-flex attributes-wrapper">
                <ul class="list-unstyled attributes">
                    <li>آموزش پروژه محور</li>
                    <li>آموزش دنباله دار</li>
                </ul>
                <ul class="list-unstyled attributes">
                    <li>آموزش پروژه محور</li>
                    <li>آموزش دنباله دار</li>
                </ul>
            </div>
            <img src="{{ asset('images/arrow.svg') }}" class="arrow-down">
            <button class="button button-secondary">
                <div class="d-flex column-gap-2 align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="40" viewBox="0 0 28 40" fill="none">
                        <path
                            d="M6 16C5.73478 16 5.48043 16.1054 5.29289 16.2929C5.10536 16.4804 5 16.7348 5 17C5 17.2652 5.10536 17.5196 5.29289 17.7071C5.48043 17.8946 5.73478 18 6 18H13C13.2652 18 13.5196 17.8946 13.7071 17.7071C13.8946 17.5196 14 17.2652 14 17C14 16.7348 13.8946 16.4804 13.7071 16.2929C13.5196 16.1054 13.2652 16 13 16H6ZM5 12C5 11.7348 5.10536 11.4804 5.29289 11.2929C5.48043 11.1054 5.73478 11 6 11H21.5C21.7652 11 22.0196 11.1054 22.2071 11.2929C22.3946 11.4804 22.5 11.7348 22.5 12C22.5 12.2652 22.3946 12.5196 22.2071 12.7071C22.0196 12.8946 21.7652 13 21.5 13H6C5.73478 13 5.48043 12.8946 5.29289 12.7071C5.10536 12.5196 5 12.2652 5 12Z"
                            fill="#323030" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5 24C5 23.7348 5.10536 23.4804 5.29289 23.2929C5.48043 23.1054 5.73478 23 6 23H10C10.2652 23 10.5196 23.1054 10.7071 23.2929C10.8946 23.4804 11 23.7348 11 24V28C11 28.2652 10.8946 28.5196 10.7071 28.7071C10.5196 28.8946 10.2652 29 10 29H6C5.73478 29 5.48043 28.8946 5.29289 28.7071C5.10536 28.5196 5 28.2652 5 28V24ZM7 27V25H9V27H7ZM18 27C18.7956 27 19.5587 26.6839 20.1213 26.1213C20.6839 25.5587 21 24.7956 21 24C21 23.2044 20.6839 22.4413 20.1213 21.8787C19.5587 21.3161 18.7956 21 18 21C17.2044 21 16.4413 21.3161 15.8787 21.8787C15.3161 22.4413 15 23.2044 15 24C15 24.7956 15.3161 25.5587 15.8787 26.1213C16.4413 26.6839 17.2044 27 18 27ZM18 25C18.1349 25.0062 18.2697 24.9849 18.3963 24.9376C18.5228 24.8902 18.6384 24.8177 18.7361 24.7245C18.8338 24.6312 18.9116 24.5191 18.9648 24.395C19.0181 24.2708 19.0456 24.1371 19.0457 24.002C19.0458 23.867 19.0186 23.7332 18.9656 23.609C18.9127 23.4847 18.8351 23.3725 18.7375 23.279C18.64 23.1855 18.5245 23.1128 18.3981 23.0652C18.2717 23.0176 18.137 22.9961 18.002 23.002C17.7448 23.0133 17.5018 23.1233 17.3237 23.3092C17.1455 23.4951 17.046 23.7426 17.0457 24C17.0454 24.2575 17.1445 24.5052 17.3223 24.6914C17.5 24.8777 17.7428 24.9882 18 25ZM12 31.182C12 29.066 15.997 28 18 28C20.003 28 24 29.066 24 31.182V35H12V31.182ZM14.055 31.222C14.0359 31.2402 14.0175 31.2592 14 31.279V33H22V31.28C21.9825 31.2595 21.9642 31.2399 21.945 31.221C21.781 31.061 21.465 30.849 20.969 30.638C19.969 30.213 18.735 30 18 30C17.265 30 16.031 30.213 15.031 30.638C14.535 30.848 14.219 31.062 14.055 31.222Z"
                            fill="#323030" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7 3C7 2.20435 7.31607 1.44129 7.87868 0.87868C8.44129 0.316071 9.20435 0 10 0H18C18.7956 0 19.5587 0.316071 20.1213 0.87868C20.6839 1.44129 21 2.20435 21 3H25C25.7956 3 26.5587 3.31607 27.1213 3.87868C27.6839 4.44129 28 5.20435 28 6V37C28 37.7957 27.6839 38.5587 27.1213 39.1213C26.5587 39.6839 25.7956 40 25 40H3C2.20435 40 1.44129 39.6839 0.878679 39.1213C0.31607 38.5587 0 37.7957 0 37V6C0 5.20435 0.31607 4.44129 0.878679 3.87868C1.44129 3.31607 2.20435 3 3 3H7ZM18 8C18.7956 8 19.5587 7.68393 20.1213 7.12132C20.6839 6.55871 21 5.79565 21 5H25C25.2652 5 25.5196 5.10536 25.7071 5.29289C25.8946 5.48043 26 5.73478 26 6V37C26 37.2652 25.8946 37.5196 25.7071 37.7071C25.5196 37.8946 25.2652 38 25 38H3C2.73478 38 2.48043 37.8946 2.29289 37.7071C2.10536 37.5196 2 37.2652 2 37V6C2 5.73478 2.10536 5.48043 2.29289 5.29289C2.48043 5.10536 2.73478 5 3 5H7C7 5.79565 7.31607 6.55871 7.87868 7.12132C8.44129 7.68393 9.20435 8 10 8H18ZM10 2C9.73478 2 9.48043 2.10536 9.29289 2.29289C9.10536 2.48043 9 2.73478 9 3V5C9 5.26522 9.10536 5.51957 9.29289 5.70711C9.48043 5.89464 9.73478 6 10 6H18C18.2652 6 18.5196 5.89464 18.7071 5.70711C18.8946 5.51957 19 5.26522 19 5V3C19 2.73478 18.8946 2.48043 18.7071 2.29289C18.5196 2.10536 18.2652 2 18 2H10Z"
                            fill="#323030" />
                    </svg>
                    همین الان شروع کن
                </div>
            </button>
        </div>
    </section>
</main>
<script src="{{ asset('assets/js/tutorials/show.js') }}"></script>
@stop
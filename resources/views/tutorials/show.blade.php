@section('title', $tutorial->title)
@section('body-class', 'bg-dark')
@extends('layouts.app')
@section('content')
<main class="container-fluid p-0 m-0">

    <div class="row bg-dark">
        <div class="col-6">
            <h1 class="text-light display-5 fw-bold mb-3">{{ $tutorial->title }}</h1>
            <p class="text-light">{!! $tutorial->short_description !!}</p>
            <div class="d-flex justify-content-start gap-2 my-4">
                <a href="#" class="btn btn-lg btn-primary btn-w-icon text-light">
                    <i class="fa fa-user-graduate me-1"></i>
                    شرکت در دوره
                </a>
                <a href="#" class="btn btn-lg btn-light btn-w-icon border">
                    <i class="fa fa-regular fa-heart"></i>
                </a>
            </div>
        </div>
        <div class="col-6">
            <video id="videoPlayer" class="w-100 rounded-3 mb-4" poster="{{ asset('storage/upload/' . $lessons->first()->thumbnail) }}">
                <source src="{{ asset('storage/upload/' . $lessons->first()->video_path) }}" type="video/mp4">
            </video>
        </div>
    </div>

    <div class="row justify-content-center my-5">
        <div class="col-8 text-bg-light rounded shadow py-3 fs-5">
            <div class="row">
                <div class="col-4">
                    <strong>طول دوره:</strong>
                    <br>
                    {{ $tutorial->duration }}
                </div>
                <div class="col-4">
                    <strong>شهریه شرکت در دوره:</strong>
                    <br>
                    {{ $tutorial->price === '0' ? $tutorial->price . ' تومان' : 'رایگان'}}
                </div>
                <div class="col-4">
                    <strong>تعداد جلسات:</strong>
                    <br>
                    {{ $lessons->count() }}
                </div>
            </div>
        </div>
    </div>

    <div class="bg-light p-5">
        <h2 class="text-center display-5 fw-bold mb-5">{{ $tutorial->title }}</h2>
        <div class="container">
            {!! $tutorial->description !!}
            @if ($tutorial->thumbnail)
            <img src="{{ asset('storage/upload/' . $tutorial->thumbnail) }}" class="w-100 rounded"
                alt="{{ $tutorial->title }}">
            @endif
        </div>
    </div>

    <div class="py-5 tutorial-syllabus">
        <img src="{{ asset('images/playlist.svg') }}" style="height:96px;" class="mx-auto d-block mb-3">
        <h2 class="text-center text-dark display-5 fw-bold mb-5">سرفصل‌های دوره</h2>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 accordion accordion-flush rounded" id="accordionFlushExample">
                <div class="accordion-item rounded shadow-sm mb-3 rounded">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button fs-5 rounded-0 collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                            aria-controls="flush-collapseOne">
                            <i class="fas fa-list me-2"></i>
                            مقدمه
                            <span class="ms-auto text-muted fw-normal small">2 جلسه</span>
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body position-relative">
                            <ul class="d-flex flex-column gap-4 timeline list-unstyled ms-3">
                                <li class="watched d-flex justify-content-between">
                                    <div>
                                        <strong>جلسه اول:</strong>
                                        نصب وی اس کد
                                    </div>
                                    <span class="small m-0 p-0">
                                        10 دقیقه
                                    </span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <div>
                                        <strong>جلسه دوم:</strong>
                                        ستاپ JS
                                    </div>
                                    <span class="small m-0 p-0">
                                        10 دقیقه
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-5 bg-light">
        <h2 class="text-center fw-bold mb-5 display-5">ویژگی های دوره</h2>
        <div class="row justify-content-center">
            <div class="col-lg-4 mb-5 text-center">
                <div class="mx-auto rounded-circle d-flex justify-content-center align-items-center"
                    style="width:140px; height: 140px;">
                    <img src="{{ asset('images/medal.png') }}" class="w-75 h-auto">
                </div>
                <h2 class="fw-normal fs-5 mt-2 mb-3">کیفیت بالا</h2>
                <p>
                    تمامی درس های این دوره قبل از ضبط و تولید، برنامه ریزی شده و تمرین ها و مسائلی که ممکنه برای مهارت آموزان مطرح بشه هم در ویدیو و هم در سرفصل دوره در نظر گرفته شده.    
                </p>
            </div>
            <div class="col-lg-4 mb-5 text-center">
                <div class="mx-auto rounded-circle d-flex justify-content-center align-items-center"
                    style="width:140px; height: 140px;">
                    <img src="{{ asset('images/study.png') }}" class="w-75 h-auto">
                </div>
                <h2 class="fw-normal fs-5 mt-2 mb-3">تمرین های مبتنی بر حل مسئله</h2>
                <p>
                    مهم ترین نکته ای که برای طراحی تمارین دوره در نظر گرفته شده، تمرین های عملی و واقعیه. هر چی تمرین واقعی تر باشه وقت و انرژی و خلاقیتی که برای حل کردنش میزاری بیشتر و بهینه تر میشه.
                </p>
            </div>
            <div class="col-lg-4 mb-5 text-center">
                <div class="mx-auto rounded-circle d-flex justify-content-center align-items-center"
                    style="width:140px; height: 140px;">
                    <img src="{{ asset('images/code.png') }}" class="w-75 h-auto">
                </div>
                <h2 class="fw-normal fs-5 mt-2 mb-3">پروژه محور و عملی</h2>
                <p>
                    در این دوره سعی شده آموزش و تمارین کاربردی و مربوط به دنیای واقعی باشه.
                </p>
            </div>
        </div>
    </div>

    <div class="py-5 bg-white">
        <h2 class="text-center fw-bold mb-5 display-5">درباره ادریس رنجبر</h2>
        <div class="profile-box mx-auto">
            <img src="{{ URL::to('/') . '/images/profile-transparent.png' }}" alt="ادریس رنجبر">
        </div>
        <p class="w-75 mx-auto text-center">
            ســــلــااام✋،
            به وب سایت من خوش اومدی. من ادریس رنجبر هستم، یه عدد برنامه نویس یا به عبارت دقیق تر،
            <strong class="fw-bold text-primary">توسعه دهنده بک اند وب.</strong>
            کار اصلیم ساخت و توسعه وب سایت و وب اپلیکیشینه و در کنارش آموزش هم میدم.
            خیلی وقت ها به صورت فریلنسری و
            فول استک کار میکنم.
            بیشتر وقتم را در دنیای کدنویسی و طراحی وب سپری می‌کنم.
            علاقه‌مند به به اشتراک گذاری تجربیات و مهارت‌هایم
            هستم و همیشه در
            تلاش برای یادگیری و بهبود خودم هستم.
            در کنار کارهای توسعه وب، من یک طبیعت‌گرد هم هستم و از ارتباط با
            طبیعت و طبیعت گردی لذت می‌برم. 🌿
        </p>
    </div>

</main>
<script src="{{ asset('assets/js/tutorials/show.js') }}"></script>
@stop
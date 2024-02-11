@section('title', $lesson->title)
@section('body-class', 'bg-light')
@extends('layouts.app')
@section('content')
<main>
    <div class="page-path text-primary mb-3">
        <a href="{{ url('/') }}">خانه</a>
        »
        <a href="{{ route('tutorials') }}">دوره ها</a>
        »
        <a href="{{ url($lesson->section->tutorial->link) }}">{{ $lesson->section->tutorial->title }}</a>
    </div>
    <div class="lesson-nav-bar w-100 d-flex flex-row-reverse justify-content-between align-items-start">
        <div>
            <a href="{{ url($prevLessonURL) }}" class="button button-secondary btn-w-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                    <g clip-path="url(#clip0_2838_293)">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.9023 21.2225C12.4458 20.7654 12.1895 20.1459 12.1895 19.5C12.1895 18.854 12.4458 18.2345 12.9023 17.7775L22.0933 8.58321C22.5506 8.12616 23.1707 7.86948 23.8172 7.86963C24.1373 7.8697 24.4543 7.93283 24.75 8.05541C25.0457 8.17798 25.3144 8.35761 25.5407 8.58402C25.7671 8.81044 25.9466 9.07921 26.069 9.375C26.1914 9.67078 26.2544 9.98779 26.2543 10.3079C26.2543 10.628 26.1911 10.945 26.0685 11.2407C25.946 11.5365 25.7663 11.8052 25.5399 12.0315L18.0731 19.5L25.5416 26.9685C25.7745 27.1932 25.9603 27.4621 26.0882 27.7594C26.2161 28.0567 26.2834 28.3765 26.2864 28.7002C26.2894 29.0238 26.2279 29.3448 26.1054 29.6445C25.983 29.9441 25.8022 30.2163 25.5734 30.4453C25.3446 30.6742 25.0726 30.8554 24.7731 30.9781C24.4736 31.1008 24.1526 31.1626 23.829 31.1599C23.5053 31.1573 23.1855 31.0902 22.888 30.9626C22.5906 30.835 22.3215 30.6494 22.0966 30.4167L12.9023 21.2225Z"
                            fill="black" />
                    </g>
                    <defs>
                        <clipPath id="clip0_2838_293">
                            <rect width="39" height="39" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </a>
        </div>
        <div>
            <div class="progress" dir="ltr">
                <div class="progress-done" style="width: {{ $progress }}%;"></div>
            </div>
            <p class="progress-label mx-auto">
                {{ $progress }}% تکمیل شده
            </p>
        </div>
        <div>
            <a href="{{ url($nextLessonURL) }}" class="button button-secondary btn-w-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                    <g clip-path="url(#clip0_2838_286)">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M26.0977 17.7775C26.5542 18.2346 26.8105 18.8541 26.8105 19.5C26.8105 20.146 26.5542 20.7655 26.0977 21.2225L16.9067 30.4168C16.4494 30.8738 15.8293 31.1305 15.1828 31.1304C14.8627 31.1303 14.5457 31.0672 14.25 30.9446C13.9543 30.822 13.6856 30.6424 13.4593 30.416C13.2329 30.1896 13.0534 29.9208 12.931 29.625C12.8086 29.3292 12.7456 29.0122 12.7457 28.6921C12.7457 28.372 12.8089 28.055 12.9315 27.7593C13.054 27.4635 13.2337 27.1948 13.4601 26.9685L20.9269 19.5L13.4584 12.0315C13.2255 11.8068 13.0397 11.5379 12.9118 11.2406C12.7839 10.9433 12.7166 10.6235 12.7136 10.2998C12.7106 9.97616 12.7721 9.65516 12.8946 9.35555C13.017 9.05593 13.1978 8.7837 13.4266 8.55473C13.6554 8.32576 13.9274 8.14464 14.2269 8.02194C14.5264 7.89923 14.8474 7.83741 15.171 7.84007C15.4947 7.84273 15.8145 7.90982 16.112 8.03742C16.4094 8.16503 16.6785 8.35059 16.9034 8.58329L26.0977 17.7775Z"
                            fill="black" />
                    </g>
                    <defs>
                        <clipPath id="clip0_2838_286">
                            <rect width="39" height="39" fill="white" transform="matrix(-1 0 0 -1 39 39)" />
                        </clipPath>
                    </defs>
                </svg>
            </a>
        </div>
    </div>
    <div class="mb-4" id="lessonContent">
        <h1 class="lesson-title">درس اول - مقدمه ای بر تاریخچه اینترنت</h1>
        <video src="{{ asset('storage/upload/' . $lesson->video_path) }}"
            poster="{{ asset('storage/upload/' . $lesson->thumbnail) }}" controls class="w-75 mx-auto rounded mb-2">
        </video>
        <span class="tutorial-description">
            {!! $lesson->description !!}
        </span>
    </div>
    <div class="mb-5" id="tabBarSection">
        <nav class="nav nav-pills nav-fill tabBarHeader" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#downloadSection" type="button"
                    role="tab" aria-controls="pills-downloadSection" aria-selected="true">دانلود فایلها</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#excersices" type="button" role="tab"
                    aria-controls="pills-excersices" aria-selected="true">حل تمرین</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#qa" type="button" role="tab"
                    aria-controls="pills-qa" aria-selected="true">پرسش و پاسخ</button>
            </li>
        </nav>
        <div class="tabBarBody">
            <div class="tab-pane fade show active" role="tabpanel" tabindex="0" id="downloadSection">
                <ul>
                    <li>
                        <a href="#">
                            دانلود فایلهای تمرین
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            دانلود کد های درس
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-pane fade" id="excersices" role="tabpanel" tabindex="0">
            </div>
            <div class="tab-pane fade" id="qa" role="tabpanel" tabindex="0">
            </div>
        </div>
    </div>
</main>
@stop
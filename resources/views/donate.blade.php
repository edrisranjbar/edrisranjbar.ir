@php
View::share('hideFooter', true);
@endphp
@section('title', 'حمایت مالی')
@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/donate.css') }}">
@endsection
@section('content')
<div id="donate-page">
    <h1 class="donate-page-title">💗 حمایت مالی</h1>
    <div class="breaker mx-auto"></div>
    <p class="donate-page-description">
        ساختن آموزش خوب و باکیفیت زمان‌بر و هزینه برداره. اگر دوست دارین توی این کار مشارکت داشته باشین
        و به تولید محتوای باکیفیت آموزشی درحوزه برنامه نویسی به زبان فارسی کمک کنین
        میتونین به نوبه خودتون سهمی در این پروسه داشته باشین
        و البته یه دلخوشی کوچیک و فانی هم برا منه😍
        <br>
        شماره کارت: 6219861910776086
        شماره شبا: IR460560611828005279097201
    </p>
    <div class="goal-row">
        <div class="donate-product-card">
            <div>
                <img class="donate-product-thumbnail" src="{{ asset('images/monitor.jpg') }}" alt="محصول">
            </div>
            <div>
                <h2 class="donate-product-title">مانیتور LG-34-inch-34WQ650</h2>
                <p class="donate-product-description">
                    یکی از لوازم ضروری، یه مانیتور اضافی برای داشتن اسنیپیت ها، ترک کردن OBS و... هست.
                </p>
            </div>
        </div>

        <div class="donate-progress-card">
            <h3 class="donation-title">تا خرید مانیتور با کیفیت</h3>
            <div class="progress-wrapper">
                <span class="donate-progress-percentage">{{ $progress }}%</span>
                <div class="donate-progress-bar">
                    <span class="donate-progress-fill" style="width: max(43px, {{ $progress }}%);"></span>
                </div>
            </div>
            <div class="donate-price-wrapper">
                <span class="price">{{ $productPrice }}</span>
                <span class="price">0</span>
            </div>
        </div>
    </div>

    <section class="donate-options">
        <h2>مبلغ پرداختی شما:</h2>
        @if (session('error'))
        <p class="text-danger text-center">{{ session('error') }}</p>
        @endif
        <div class="d-flex flex-column gap-2 mx-auto">
            <div class="d-flex gap-2">
                <button class="button button-outline-primary" value="10000">10,000</button>
                <button class="button button-outline-primary active" value="100000">100,000</button>
                <button class="button button-outline-primary" value="500000">500,000</button>
            </div>
            <div class="d-flex gap-2">
                <button class="button button-outline-primary" value="1000000">1,000,000</button>
                <button class="button button-outline-primary" value="2000000">2,000,000</button>
                <button class="button button-outline-primary" id="custom-amount-btn" value="250000">مبلغ
                    دلخواه</button>
            </div>
            <form action="{{ route('donation.request') }}" method="POST" id="donate-form">
                @csrf
                <input form="donate-form" value="100000" name="amount" type="number" min="1000"
                    class="form-control d-none" id="custom-amount-field">
            </form>
            <button type="submit" id="donate-button" class="button button-primary" form="donate-form">
                همین الان پرداخت کن
            </button>
        </div>
    </section>

    <section id="share">
        <span class="donate-share-button">
            <svg style="margin-left: 8px;" width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M18 22C17.1667 22 16.4583 21.7083 15.875 21.125C15.2917 20.5417 15 19.8333 15 19C15 18.8833 15.0083 18.7623 15.025 18.637C15.0417 18.5117 15.0667 18.3993 15.1 18.3L8.05 14.2C7.76667 14.45 7.45 14.646 7.1 14.788C6.75 14.93 6.38333 15.0007 6 15C5.16667 15 4.45833 14.7083 3.875 14.125C3.29167 13.5417 3 12.8333 3 12C3 11.1667 3.29167 10.4583 3.875 9.875C4.45833 9.29167 5.16667 9 6 9C6.38333 9 6.75 9.071 7.1 9.213C7.45 9.355 7.76667 9.55067 8.05 9.8L15.1 5.7C15.0667 5.6 15.0417 5.48767 15.025 5.363C15.0083 5.23833 15 5.11733 15 5C15 4.16667 15.2917 3.45833 15.875 2.875C16.4583 2.29167 17.1667 2 18 2C18.8333 2 19.5417 2.29167 20.125 2.875C20.7083 3.45833 21 4.16667 21 5C21 5.83333 20.7083 6.54167 20.125 7.125C19.5417 7.70833 18.8333 8 18 8C17.6167 8 17.25 7.92933 16.9 7.788C16.55 7.64667 16.2333 7.45067 15.95 7.2L8.9 11.3C8.93333 11.4 8.95833 11.5127 8.975 11.638C8.99167 11.7633 9 11.884 9 12C9 12.116 8.99167 12.237 8.975 12.363C8.95833 12.489 8.93333 12.6013 8.9 12.7L15.95 16.8C16.2333 16.55 16.55 16.3543 16.9 16.213C17.25 16.0717 17.6167 16.0007 18 16C18.8333 16 19.5417 16.2917 20.125 16.875C20.7083 17.4583 21 18.1667 21 19C21 19.8333 20.7083 20.5417 20.125 21.125C19.5417 21.7083 18.8333 22 18 22Z"
                    fill="#E0E0E0" />
            </svg>
            اشتراک گذاری
        </span>
    </section>

    <div class="background-effects">
        <div class="rectangle-1"></div>
        <div class="rectangle-2"></div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 start-0 p-3">
    <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true"
        id="successToast">
        <div class="d-flex">
            <div class="toast-body">
                لینک صفحه حمایت باموفقیت کپی شد
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{ asset('assets/js/donate.js') }}"></script>
@endsection
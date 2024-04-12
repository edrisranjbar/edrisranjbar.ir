@php
View::share('hideFooter', true);
View::share('hideHeader', true);
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
        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه
        روزنامه
        و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود
        ابزارهای
        کاربردی می باشد.
    </p>
    <div class="goal-row">
        <div class="donate-product-card">
            <div>
                <img class="donate-product-thumbnail" src="/images/bs.png" alt="محصول">
            </div>
            <div>
                <h2 class="donate-product-title">میکروفون استودیویی Rode Xy-89</h2>
                <p class="donate-product-description">
                    خرید میکروفون حرفه ای برای ضبط ویدیو ها با کیفیت صدای بهتر.
                </p>
            </div>
        </div>

        <div class="donate-progress-card">
            <h3 class="donation-title">تا خرید میکروفون استودیویی حرفه‌ای</h3>
            <div class="progress-wrapper">
                <span class="donate-progress-percentage">90%</span>
                <div class="donate-progress-bar">
                    <span class="donate-progress-fill" style="width: 90%"></span>
                </div>
            </div>
            <div class="donate-price-wrapper">
                <span class="price">0</span>
                <span class="price">10,000,000</span>
            </div>
        </div>
    </div>

    <section class="donate-options">
        <h2>مبلغ پرداختی شما:</h2>
        <div class="d-flex flex-column gap-2 mx-auto">
            <div class="d-flex gap-2">
                <button class="button button-outline-primary" value="10000">10,000</button>
                <button class="button button-outline-primary active" value="100000">100,000</button>
                <button class="button button-outline-primary" value="500000">500,000</button>
            </div>
<div class="d-flex gap-2">
                <button class="button button-outline-primary" value="1000000">1,000,000</button>
                <button class="button button-outline-primary" value="2000000">2,000,000</button>
                <button class="button button-outline-primary" id="custom-amount-btn" value="250000">مبلغ دلخواه</button>
            </div>
            <input name="amount" type="number" min="10000" class="form-control d-none" id="custom-amount-field">
            <button type="submit" id="donate-button" class="button button-primary">
                همین الان پرداخت کن
            </button>
        </div>
    </section>
    
    <div class="background-effects">
        <div class="rectangle-1"></div>
        <div class="rectangle-2"></div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/js/donate.js') }}"></script>
@endsection
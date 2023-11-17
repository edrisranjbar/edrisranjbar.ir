@section('title', 'صفحه یافت نشد')
@section('body-class', 'bg-dark')
@php
View::share('hideFooter', true);
View::share('hideHeader', true);
@endphp
@extends('layouts.app')
@section('content')
<main class="container-404">
    <img src="{{ asset('images/404.svg') }}" alt="صفحه یافت نشد" class="404">
    <h1>صفحه مورد نظر یافت نشد!</h1>
    <p class="h4 fw-normal">مطئمنی آدرس رو درست اومدی؟</p>
    <div class="d-flex gap-2">
        <a href="{{ url('/') }}" class="btn btn-primary text-light btn-w-icon">
            <i class="fa fa-solid fa-home me-1"></i>
            برگرد صفحه اصلی
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary text-light btn-w-icon">
            <i class="fa fa-solid fa-arrow-right me-1"></i>
            برگرد همونجایی که بودم
        </a>
    </div>
</main>
@stop
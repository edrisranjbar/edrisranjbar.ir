@section('title', $tutorial->title)
@section('body-class', 'bg-light')
@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb" class="breadcrumb-wrapper">
    <ol class="breadcrumb mb-0 py-2 px-3">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}">خانه</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ url($tutorial->link) }}">{{ $tutorial->title }}</a>
        </li>
    </ol>
</nav>
<main class="container-fluid">
    <div class="row mt-3">
        <article class="col-12 col-md-8">
            <div class="p-2">
                <video src="#" class="w-100 rounded-3 mb-4" controls></video>
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" data-bs-toggle="tab" href="#tab1">
                            توضیحات دوره
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab2">سرفصل ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab3">نظرات</a>
                    </li>
                </ul>
                <div class="tab-content mt-2">
                    <div class="tab-pane fade show active" id="tab1">
                        {!! $tutorial->description !!}
                    </div>
                    <div class="tab-pane fade" id="tab2">
                        تست
                    </div>
                    <div class="tab-pane fade" id="tab3">
                        تست 2
                    </div>
                </div>
            </div>
        </article>
        <aside class="col-12 col-md-4 bg-light">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 card-title mb-3">{{ $tutorial->title }}</h1>
                    <p class="h5 fw-normal">شهریه دوره: {{ $tutorial->price }} تومان</p>
                    <p class="h5 fw-normal">
                        مدرس: ادریس رنجبر
                    </p>
                    <div class="d-flex justify-content-start gap-2 my-4">
                        <a href="#" class="btn btn-lg btn-primary btn-w-icon text-light">
                            <i class="fa fa-user-graduate me-1"></i>
                            شرکت در دوره
                        </a>
                        <a href="#" class="btn btn-lg btn-outline-light btn-w-icon border">
                            <i class="fa fa-regular fa-heart"></i>
                        </a>
                    </div>
                    <p class="d-flex justify-content-around">
                        <span>تعداد دانشجو:</span>&nbsp;
                        <span>{{ $tutorial->students()->count() }} نفر</span>
                    </p>
                    <p class="d-flex justify-content-around">
                        <span>مدت دوره:</span>&nbsp;
                        <span>{{ $tutorial->duration }} دقیقه</span>
                    </p>
                </div>
            </div>
        </aside>
    </div>
</main>
@stop
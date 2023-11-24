@section('title', $tutorial->title)
@section('body-class', 'bg-dark')
@extends('layouts.app')
@section('content')
<main class="container-fluid p-0 m-0">

    <div class="row">
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
            <video src="{{ asset('storage/upload/' . $lessons->first()->video_path) }}" class="w-100 rounded-3 mb-4"
                controls></video>
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

    <div class="container bg-light py-5 rounded">
        <h2 class="text-center display-5 fw-bold mb-5">درباره {{ $tutorial->title }}</h2>
        {!! $tutorial->description !!}
        @if ($tutorial->thumbnail)
        <img src="{{ asset('storage/upload/' . $tutorial->thumbnail) }}" class="w-100 rounded"
            alt="{{ $tutorial->title }}">
        @endif
    </div>

    <div class="container-fluid py-5 mb-5 tutorial-syllabus">
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

</main>
@stop
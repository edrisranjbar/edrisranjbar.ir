@section('title', 'داشبورد')
@extends('layouts.user')
@section('content')
<div class="container-fluid text-right">
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h5 class="font-weight-bold text-primary mb-2">دوره های من</h5>
                            <div class="h3 me-3 mb-0 text-gray-800">
                                {{ $user->tutorials->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-3 d-flex flex-column">
                            <h5 class="font-weight-bold text-info mb-2">پیشرفت کل</h5>
                            <div class="progress" role="progressbar" aria-valuenow="{{ $averageTotalProgress }}" aria-valuemin="0"
                                aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped bg-info progress-bar-animated"
                                    style="width: {{$averageTotalProgress}}%"></div>
                            </div>
                            <div class="fs-5 mt-2 mb-0 text-gray-800">
                                {{ $averageTotalProgress }}% پیش رفتی ایول🎉
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa fa-line-chart fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h5 class="font-weight-bold text-success mb-2">درس های پاس شده</h5>
                            <div class="h3 mb-0 ml-3 text-gray-800">
                                0
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa fa-check-circle fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="font-weight-bold text-primary mb-4">دوره‌های ثبت‌نام شده</h5>
                    <ul class="list-group">
                        @forelse($user->tutorials ?? [] as $enrolledTutorial)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ $enrolledTutorial->link}}">{{ $enrolledTutorial->title }}</a>
                            <span class="badge bg-success rounded-pill">کامل شده</span>
                        </li>
                        @empty
                        <li class="list-group-item">شما در هیچ دوره‌ای ثبت‌نام نکرده‌اید.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="font-weight-bold text-primary mb-3">دوره‌ی پیشنهادی</h5>
                    @if($suggestedTutorial)
                    <div class="text-center">
                        <a href="{{ $suggestedTutorial->link }}">
                            @if ($suggestedTutorial->thumbnail)
                            <img src="{{ asset('storage/upload/' . $suggestedTutorial->thumbnail) }}"
                            class="img-fluid rounded" alt="{{ $suggestedTutorial->title }}">
                            @endif
                        </a>
                    </div>
                    @else
                    <p class="w-100 text-center">دوره‌ای پیشنهاد نشده است.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="card col-12 p-5 text-center bg-body-tertiary rounded-3 text-center position-relative">
            <button type="button" class="position-absolute top-0 start-0 p-3 m-3 btn-close bg-secondary bg-opacity-10 rounded-pill"
                aria-label="Close" onclick="this.parentElement.parentElement.remove();"></button>
            <h5 class="fs-3 fw-bold">حمایت مالی</h5>
            <p class="lead text-muted">
                اگر از دوره‌های ما استفاده می‌کنید و می‌خواهید ما را حمایت کنید، می‌توانید با یک مبلغ دلخواه به ما کمک کنید.
            </p>
            <a href="https://zarinp.al/edrisranjbar" target="_blank" class="btn btn-outline-primary btn-w-icon mx-auto">
                یه مقداری حمایت میکنم
            </a>
        </div>
    </div>
    <div class="row my-5 py-5 text-bg-dark rounded-4">
        <h5 class="text-center my-5">بخش‌های جدید به زودی!</h5>
    </div>
</div>
@stop
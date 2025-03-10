@extends('layouts.admin')
@section('title', 'داشبود')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid text-right">
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h6 class="h5 font-weight-bold text-dark mb-2">نوشته ها</h6>
                            <div class="h3 ml-3 mb-0 text-dark">
                                {{ $postsCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h6 class="h5 font-weight-bold text-dark mb-2">دانش آموزان</h6>
                            <div class="ml-3 h3 mb-0 text-dark">
                                <span>{{ $studentsCount }}</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h6 class="h5 font-weight-bold text-dark mb-2">بازدیدکنندگان امروز</h6>
                            <div class="h3 ml-3 mb-0 text-dark">{{ $totalViewers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-right-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h6 class="h5 font-weight-bold text-dark mb-2">بازدید امروز</h6>
                            <div class="h3 mb-0 ml-3 text-dark">
                                {{ $totalViews }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa fa-line-chart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 h5 font-weight-bold text-dark">آخرین نظرات</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group mx-0 px-0 w-100">
                        @forelse($comments as $comment)
                        <li class="list-group-item">
                            <small class="d-inline-block mt-1 float-left badge badge-pill badge-secondary">
                                {{ $comment->updatedAgo }}
                            </small>
                            <strong>{{ $comment->author->name }}:</strong>
                            <div class="text-wrap mb-2">{!! $comment->message !!}</div>
                            @if ($comment->reply_message)
                            <div class="comment_reply rounded shadow bg-light p-3 my-2">
                                <i class="fa fa-reply ml-2"></i>
                                <span class="text-wrap">{!! nl2br($comment->reply_message) !!}</span>
                            </div>
                            @endif
                        </li>
                        @empty
                        <li class="list-group-item text-center">
                            نتیجه ای یافت نشد
                        </li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer">
                    <a class="btn btn-outline-dark btn-w-icon d-inline-block w-fit-content"
                        href="{{ url('admin/comments') }}">
                        <i class="fa fas fa-eye me-1"></i>
                        نمایش همه دیدگاه‌ها
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 h5 font-weight-bold text-dark">آمار بازدید ها</h6>
                </div>
                <div class="card-body py-5">
                    <canvas id="viewsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 h5 font-weight-bold text-dark">آخرین نوشته ها</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group mx-0 px-0 w-100">
                        @forelse($posts as $post)
                        <li class="list-group-item">
                            <a href="{{ url('admin/posts/' . $post->id) }}">{{ $post->title }}</a>
                        </li>
                        @empty
                        <li class="list-group-item text-center">
                            نتیجه ای یافت نشد
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    const viewsData = @json($currentWeekViews);
        const viewersData = @json($currentWeekViewers);
        const labels = @json($lastWeekDates);
</script>
@stop
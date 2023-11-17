@section('title', 'دوره های آموزشی')
@section('body-class', 'bg-light')
@extends('layouts.app')
@section('content')
<main>
    <div class="page-title-group">
        <h1 class="page-title">دوره های آموزشی</h1>
        <div class="page-path text-primary">خانه » دوره ها</div>
    </div>
    <div class="my-card-group">
        @foreach($tutorials as $tutorial)
        <div class="card bg-light tutorial">
            <a href="{{ $tutorial->link }}">
                @if ($tutorial->thumbnail)
                <img src="{{ asset('storage/upload/' . $tutorial->thumbnail) }}" class="thumbnail" alt="{{ $tutorial->title }}">
                @endif
                <h3 class="post-title">{{ $tutorial->title }}</h3>
            </a>
            <div class="d-flex post-meta">
                <a href="{{ $tutorial->link }}" class="btn btn-sm btn-outline-primary btn-w-icon">
                    <i class="fa fa-solid fa-eye me-1"></i>
                    مشاهده
                </a>
                <div class="d-flex align-items-center students-count">
                    <i class="fas fa-user-circle"></i>
                    دانشجویان: {{ $tutorial->students()->count() }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</main>
@stop
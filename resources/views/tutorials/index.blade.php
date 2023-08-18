@section('title', 'دوره های آموزشی')
@extends('layouts.app')
@section('content')
<main>
    <div class="page-title-group">
        <h1 class="page-title">دوره های آموزشی</h1>
        <div class="page-path">خانه » دوره ها</div>
    </div>
    <div class="my-card-group">
        @foreach($tutorials as $tutorial)
        <div class="my-card">
            <div class="my-card-body">
                <div class="my-card-image">
                    <a href="{{ url('tutorials/' . $tutorial->slug) }}">
                        <img class="rounded" src="{{ asset('storage/upload/' . $tutorial->thumbnail) }}" alt="{{ $tutorial->title }}">
                    </a>
                </div>
                <div class="my-card-title mt-2">
                    <a href="{{ url('tutorials/' . $tutorial->slug) }}">
                        {{ $tutorial->title }}
                    </a>
                </div>
            </div>
            <div class="my-card-footer">
                <div>
                    <button class="button button-purple">مشاهده</button>
                </div>
                <div class="student-count">
                    <i class="fas fa-user-circle"></i>
                    <span>دانشجویان: {{ $tutorial->students()->count() }} نفر</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</main>
@stop
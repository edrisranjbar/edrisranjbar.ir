@section('title', 'دوره های آموزشی')
@extends('layouts.app')
@section('content')
    <main>
        <div class="page-title-group">
            <h1 class="page-title">دوره های آموزشی</h1>
            <div class="page-path text-primary">
                <a href="{{ url('/') }}">خانه</a>
                »
                <a href="{{ route('tutorials') }}">دوره ها</a>
            </div>
        </div>
        <div class="my-card-group mb-5">
            @foreach($tutorials as $tutorial)
                <div class="card tutorial animated-card">
                    <a href="{{ $tutorial->link }}">
                        @if ($tutorial->thumbnail)
                            <img src="{{ asset('storage/upload/' . $tutorial->thumbnail) }}"
                                 class="card-img-top" alt="{{ $tutorial->title }}">
                        @endif
                    </a>
                    <div class="card-body w-100">
                        <a href="{{ $tutorial->link }}">
                            <h3 class="card-title h4">{{ $tutorial->title }}</h3>
                        </a>
                        <p class="card-text">{{ $tutorial->excerpt }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ $tutorial->link }}" class="btn btn-outline-primary btn-w-icon">
                                <i class="fa fa-solid fa-eye me-1"></i>
                                مشاهده دوره
                            </a>
                            <div class="d-flex align-items-center students-count">
                                {{ $tutorial->priceLabel }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@stop
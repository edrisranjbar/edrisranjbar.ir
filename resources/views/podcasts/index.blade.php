@section('title', 'پادکست ها')
@extends('layouts.app')
@section('content')
<main class="container mt-0">
    <div class="jumbotron jumbotron-fluid text-center text-bg-primary text-white py-2 rounded shadow mb-5">
        <div class="container">
            <h1 class="display-5 mb-4">بهترین پادکست‌ها</h1>
            <p class="lead">گوش دادن به داستان‌ها و گفتگوهای جذاب از بهترین پادکست‌ها</p>
        </div>
    </div>
    <div class="row">
        @foreach($episodes as $episode)
        <div class="col-12 col-md-4">
            <div class="card rounded-4 shadow-sm position-relative">
                @if($loop->iteration === 1)
                <span class="badge bg-primary position-absolute end-0 top-0 m-2">
                    جدید
                </span>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $episode['title'] }}</h5>
                    <p class="card-text">
                        {!! $episode['description'] !!}
                    </p>
                    <audio controls class="w-100" preload="metadata">
                        <source src="{{ $episode['file'] }}" type="{{ $episode['type'] }}">
                    </audio>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</main>
@stop
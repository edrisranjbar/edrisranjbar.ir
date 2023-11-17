@section('title', 'پادکست ها')
@section('body-class', 'bg-light')
@extends('layouts.app')
@section('content')
<main class="container-fluid">
    <div class="jumbotron jumbotron-fluid text-center text-bg-primary text-white py-2 rounded shadow mb-5">
        <div class="container">
            <h1 class="display-5 mb-4">بهترین پادکست‌ها</h1>
            <p class="lead">گوش دادن به داستان‌ها و گفتگوهای جذاب از بهترین پادکست‌ها</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card rounded-4 shadow-sm">
                <img src="{{ asset('images/web-browsing.png') }}" alt="" class="card-img-top rounded-top-4 rounded-bottom-0">
                <div class="card-body">
                    <h5 class="card-title">قسمت اول: هوش مصنوعی ضعیف و قوی</h5>
                    <p class="card-text">
                        این قسمت در مورد انواع هوش مصنوعی، تعریف و مشخصات هرکدوم صحبت می کنیم.
                    </p>
                    <audio controls class="w-100">
                        <source src="path/to/your/audio.mp3" type="audio/mp3">
                    </audio>
                </div>
            </div>
        </div>
    </div>
</main>
@stop
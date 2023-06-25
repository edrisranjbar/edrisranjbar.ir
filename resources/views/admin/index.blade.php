@extends('layouts.admin')
@section('title', 'داشبود')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid text-right">
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h6 class="font-weight-bold text-primary mb-2">نوشته ها</h6>
                            <div class="h3 ml-3 mb-0 text-gray-800">
                                ۱۷
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
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h6 class="font-weight-bold text-success mb-2">دانش آموزان</h6>
                            <div class="ml-3 h3 mb-0 text-gray-800">
                                <span>۲۰</span>
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
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h6 class="font-weight-bold text-info mb-2">بازدید کنندگان امروز</h6>
                            <div class="h3 ml-3 mb-0 text-gray-800">۹۸</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h6 class="font-weight-bold text-warning mb-2">بازدید های امروز</h6>
                            <div class="h3 mb-0 ml-3 text-gray-800">
                                ۱۲۳ </div>
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
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">آخرین نظرات</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group mx-0 px-0 w-100">
                        <li class="list-group-item">
                            <strong>ادریس رنجبر:</strong> مطلب خوبی بود! مرسی ازت
                            <br><small
                                class="d-inline-block mt-1 float-left bdage badge-pill badge-secondary">۱۳۹۹/۰۳/۲۲ -
                                ۱۰:۳۰
                                قبل از
                                ظهر</small>
                        </li>
                        <li class="list-group-item">
                            <strong>لورم ایپسوم:</strong> اون قسمت توی ۲۰:۷۶ چه تگی زدی پیدا نیست؟
                            <br><small
                                class="d-inline-block mt-1 float-left bdage badge-pill badge-secondary">۱۳۹۹/۰۳/۲۳ -
                                ۰۱:۱۴
                                بعد از
                                ظهر</small>
                        </li>
                        <li class="list-group-item">
                            <strong>لورم ایپسوم:</strong> اون قسمت توی ۲۰:۷۶ چه تگی زدی پیدا نیست؟ اون قسمت توی ۲۰:۷۶ چه
                            تگی زدی پیدا نیست؟ اون قسمت توی ۲۰:۷۶ چه تگی زدی پیدا نیست؟
                            <br><small
                                class="d-inline-block mt-1 float-left bdage badge-pill badge-secondary">۱۳۹۹/۰۳/۲۳ -
                                ۰۹:۴۵
                                صبح</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">آمار بازدید ها</h6>
                </div>
                <div class="card-body py-5">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@stop
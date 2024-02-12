@extends('layouts.login')
@section('title', 'ثبت نام')
@section('content')
    <section class="vh-100 bg-primary">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card rounded-4">
                        <div class="row g-0">
                            <div class="col-12 col-md-6 col-lg-5 d-none d-md-block d-flex align-items-center justify-content-center">
                                <img src="{{ asset('images/login.svg') }}"
                                     class="mx-5 mt-3 mt-md-0 w-100 h-100 rounded">
                            </div>
                            <div class="col-12 col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body px-4 px-lg-5 text-black">
                                    <form method="post" action="{{ route('user.register') }}" class="needs-validation"
                                          novalidate>
                                        @csrf
                                        <h1 class="h3 fw-normal text-center mt-3 mb-5">فرم ثبت نام</h1>
                                        <div class="form-group">
                                            <label for="name" class="float-right">نام و نام خانوادگی</label>
                                            <input name="name" type="text" class="form-control" id="name"
                                                   placeholder="نام و نام خانوادگی" value="{{ old('name') }}" required>
                                            <div class="invalid-feedback text-right">
                                                لطفا نام و نام خانوادگی خود را وارد کنید
                                            </div>
                                            @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="float-right">ایمیل</label>
                                            <input name="email" type="email" class="form-control" id="email"
                                                   placeholder="ایمیل" value="{{ old('email') }}" required>
                                            <div class="invalid-feedback text-right">
                                                لطفا ایمیل معتبری وارد کنید
                                            </div>
                                            @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="float-right">رمز عبور</label>
                                            <input name="password" type="password" class="form-control" id="password"
                                                   placeholder="رمز عبور" required>
                                            <div class="invalid-feedback text-right mb-4">
                                                لطفا رمز عبور معتبری وارد کنید
                                            </div>
                                            @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button class="w-100 btn btn-lg btn-primary" type="submit">
                                            ثبت نام
                                        </button>
                                        <a class="w-100 btn btn-lg btn-outline-primary mt-2"
                                           href="{{ route('user.login') }}">
                                            ورود به حساب کاربری
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

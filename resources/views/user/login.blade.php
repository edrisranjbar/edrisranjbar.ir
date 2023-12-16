@section('title', 'ورود')
@extends('layouts.login')
@section('content')

<section class="vh-100 bg-primary">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card rounded-4">
                    <div class="row g-0">
                        <div class="col-12 col-md-6 col-lg-5 d-none d-md-block d-flex align-items-center justify-content-center">
                            <img src="{{ asset('images/login.svg') }}" class="mx-5 mt-3 mt-md-0 w-100 h-100 rounded">
                        </div>
                        <div class="col-12 col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body px-4 px-lg-5 text-black">
                                @if (session('success'))
                                <div class="alert alert-success alert-dismissible d-flex align-items-center fade show"
                                    role="alert">
                                    <i class="bi-check-circle-fill"></i>
                                    <div>
                                        {{ session('success') }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif
                                <form method="post" action="{{ url('user/login') }}" class="needs-validation" novalidate>
                                    @csrf
                                    <h1 class="h3 fw-normal text-center mt-3 mb-5">لطفا وارد شوید</h1>
                                    @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible d-flex align-items-center fade show"
                                        role="alert">
                                        {{ session('error') }}
                                    </div>
                                    @endif
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
                                        ورود
                                    </button>
                                    <a class="mt-4 d-block btn-link" href="{{ route('user.password.reset') }}">فراموشی رمز
                                        عبور</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
<script src="{{ asset('assets\js\login.js') }}" defer></script>
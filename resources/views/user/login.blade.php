@section('title', 'ورود')
@section('header-class', 'bg-dark')
@extends('layouts.login')
@section('content')

<h1 class="login-form-title">
    ورود یا عضویت
</h1>

<form method="post" action="{{ url('user/login') }}" class="needs-validation" novalidate>
    @csrf
    @include('templates.messages')

    <input name="email" type="email" class="login-input" placeholder="ایمیل" required>
    @error('email')
    <p class="text-danger">{{ $message }}</p>
    @enderror



    <input name="password" type="password" class="login-input" placeholder="رمز عبور" required minlength="3">
    @error('password')
    <p class="text-danger">{{ $message }}</p>
    @enderror

    <button class="button button-secondary mx-auto" type="submit">
        ورود یا ثبت نام
    </button>
    <a href="" class="text-light d-block fs-5">
        فراموشی رمز عبور
    </a>
</form>

@stop
<script src="{{ asset('assets\js\login.js') }}" defer></script>
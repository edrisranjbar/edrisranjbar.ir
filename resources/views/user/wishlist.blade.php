@section('title', 'پروفایل کاربری')
@extends('layouts.user')
@section('content')
<main class="container-lg">
    <h2 class="mb-3">لیست علاقه‌مندی‌های شما</h2>
    @if($wishlistItems->count() <= 0)
    <ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        لیست علاقه‌مندی‌های شما خالی است.
    </li>
    @else
        @foreach($wishlistItems as $wishlistItem)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h5>{{ $wishlistItem->tutorial->title }}</h5>
                <p>{{ $wishlistItem->tutorial->description }}</p>
            </div>
            <form action="{{ route('tutorials.enroll', ['slug' => $wishlistItem->tutorial->id]) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-heart text-danger"></i>
                    همین حالا ثبت نام کنید
                </button>
            </form>
        </li>
        @endforeach
    </ul>
    @endif
</main>
@stop
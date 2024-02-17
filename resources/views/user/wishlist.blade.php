@section('title', 'لیست علاقه‌مندی ها')
@extends('layouts.user')
@section('content')
<main class="container-lg">
    <h2 class="mb-3">لیست علاقه‌مندی‌های شما</h2>
    @include('templates.messages')
    <ul class="list-group">
        @if($wishlistItems->count() <= 0)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                لیست علاقه‌مندی‌های شما خالی است.
            </li>
            @else
            @foreach($wishlistItems as $wishlistItem)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <h5 class="my-0 py-0">{{ $wishlistItem->tutorial->title }}</h5>
                <form action="{{ route('wishlist.addOrRemove', ['id' => $wishlistItem->tutorial->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-w-icon">
                        <svg class="me-1" width="30" height="30" viewBox="0 0 30 30" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20.8594 3.75C18.4395 3.75 16.3207 4.79062 15 6.54961C13.6793 4.79062 11.5605 3.75 9.14062 3.75C7.21433 3.75217 5.36755 4.51835 4.00545 5.88045C2.64335 7.24255 1.87717 9.08933 1.875 11.0156C1.875 19.2187 14.0379 25.8586 14.5559 26.1328C14.6924 26.2063 14.845 26.2447 15 26.2447C15.155 26.2447 15.3076 26.2063 15.4441 26.1328C15.9621 25.8586 28.125 19.2187 28.125 11.0156C28.1228 9.08933 27.3566 7.24255 25.9946 5.88045C24.6325 4.51835 22.7857 3.75217 20.8594 3.75Z"
                                fill="#FF0000" />
                        </svg>
                        حذف از علاقه مندی ها
                    </button>
                </form>
            </li>
            @endforeach
            @endif
    </ul>
</main>
@stop
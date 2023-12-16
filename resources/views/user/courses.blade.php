@section('title', 'داشبورد')
@extends('layouts.user')
@section('content')
<ul class="list-group">
    @forelse($tutorials ?? [] as $tutorial)
    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <a href="{{ $tutorial->link }}">
            {{ $tutorial->title }}
            <span class="badge bg-primary rounded-pill">-%</span>
        </a>
    </li>
    @empty
    <li class="list-group-item text-center fw-bold py-5">
        <span class="display-3">🥺</span>
        <br>
        <p class="fs-3 fw-bold mt-2">هنوز که توی دوره ای شرکت نکردی!</p>
    </li>
    @endforelse
</ul>
@stop
@section('title', 'داشبورد')
@extends('layouts.user')
@section('content')
<ul class="list-group">
    @forelse($tutorials ?? [] as $tutorial)
    @php
        $userProgress = $user->tutorialProgress()->where('tutorial_id', $tutorial->id)->first();
        $progressPercentage = $userProgress ? $userProgress->progress : 0;
    @endphp
    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <a href="{{ $tutorial->link }}">
            {{ $tutorial->title }}
            @if($progressPercentage === 0)
            <span class="badge bg-warning rounded-pill">
                تازه شروع کردی!
            </span>
            @elseif($progressPercentage === 100)
            <span class="badge bg-success rounded-pill">
               کامل شده
            </span>
            @else
            <span class="badge bg-primary rounded-pill">
                {{ $progressPercentage  }}%
            </span>
            @endif
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
@section('title', 'داشبورد')
@extends('layouts.user')
@section('content')
    <div class="row gap-3">
        @forelse($tutorials ?? [] as $tutorial)
            @php
                $userProgress = $user->tutorialProgress()->where('tutorial_id', $tutorial->id)->first();
                $progressPercentage = $userProgress ? $userProgress->progress : 0;
            @endphp
            <div class="col-12 col-md-4">
                <div class="card rounded bg-light tutorial">
                    <a href="{{ $tutorial->link }}">
                        @if ($tutorial->thumbnail)
                            <img src="{{ asset('storage/upload/' . $tutorial->thumbnail) }}"
                                 class="thumbnail w-100 rounded-top"
                                 alt="{{ $tutorial->title }}">
                        @endif
                        <h3 class="post-title mx-3">{{ $tutorial->title }}</h3>
                    </a>
                    <div class="card-footer d-flex w-100 justify-content-between px-3">
                        <a href="{{ $tutorial->link }}" class="btn btn-sm btn-outline-primary btn-w-icon">
                            <i class="fa fa-solid fa-eye me-1"></i>
                            مشاهده
                        </a>
                        <div class="d-flex align-items-center">
                            @if($progressPercentage === 0)
                                <span class="badge text-bg-warning rounded px-2 py-1">
                            تازه شروع کردی!
                        </span>
                            @elseif($progressPercentage === 100)
                                <span class="badge text-bg-success rounded px-2 py-1">
                           کامل شده
                        </span>
                            @else
                                <span class="badge text-bg-primary rounded px-2 py-1">
                            {{ $progressPercentage  }}%
                        </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item text-center fw-bold py-5 rounded">
                <span class="display-3">🥺</span>
                <br>
                <p class="fs-3 fw-bold mt-2">هنوز که توی دوره ای شرکت نکردی!</p>
            </div>
        @endforelse
    </div>
@stop
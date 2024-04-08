@section('title', 'فرم های ارتباط با ما')
@extends('layouts.admin')
@section('content')
<div class="container-lg px-md-5 px-4 text-right" dir="rtl">
    <div class="card shadow">
        <div class="card-body">
            @include('templates.messages')
            <ul class="list-group mx-0 px-0 w-100">
                @forelse($forms as $form)
                <li class="list-group-item">
                    <small class="d-inline-block mt-1 float-left badge badge-pill badge-secondary">
                        {{ $form->updatedAgo }}
                    </small>
                    <strong>{{ $form->name }} ({{ $form->email}}):</strong>
                    <p>{{ $form->subject }}</p>
                    <div class="text-wrap mb-2">{!! $form->message !!}</div>
                </li>
                @empty
                <li class="list-group-item text-center">
                    نتیجه ای یافت نشد
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
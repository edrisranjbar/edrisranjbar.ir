@section('title', 'فرم های ارتباط با ما')
@extends('layouts.admin')
@section('content')
<div class="container-lg px-md-5 px-4 text-right" dir="rtl">
    <div class="card shadow">
        <div class="card-body">
            @include('templates.messages')
            @if(count($forms) > 0)
            <form action="{{ route('contactForms.destroyAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm mb-3 float-end btn-outline-danger btn-w-icon w-fit-content d-inline-block">
                    <i class="fas fa-trash me-1"></i>
                    حذف همه
                </button>
            </form>
            @endif
            <ul class="list-group mx-0 px-0 w-100">
                @forelse($forms as $form)
                <li class="list-group-item">
                    <form action="{{ route('contactForms.destroy', $form->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                        class="d-inline-block mt-1 float-left me-1 badge
                        border-0 text-bg-danger p-2 clickable-badge">
                            حذف
                        </button>
                    </form>

                    <strong>{{ $form->name }} ({{ $form->email}}):</strong>
                    <p class="d-inline-block badge badge-pill badge-secondary">
                        {{ $form->updatedAgo }}
                    </p>
                    <p>{{ $form->subject }}</p>
                    <div class="text-wrap mb-2">{!! $form->message !!}</div>
                </li>
                @empty
                <li class="list-group-item text-center">
                    نتیجه ای یافت نشد
                </li>
                @endforelse
            </ul>
            {{ $forms->links('templates.pagination') }}
        </div>
    </div>
</div>
@endsection
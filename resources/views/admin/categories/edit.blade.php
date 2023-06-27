@section('title', 'ویرایش دسته‌بندی')
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">ویرایش دسته‌بندی</h1>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <form class="w-100 p-3 bg-white rounded shadow-sm border" action="{{ route('categories.update', $category->id) }}"
        method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">عنوان</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $category->title }}" required>
            @error('title')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">توضیحات</label>
            <textarea name="description" id="description" class="form-control"
                rows="5">{{ $category->description }}</textarea>
            @error('description')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">شناسه یکتا</label>
            <input type="text" name="slug" id="slug" class="form-control" pattern="[a-zA-Z]+" maxlength="50" min="1"
                value="{{ $category->slug }}" required>
            @error('slug')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="d-flex flex-wrap mt-2">
            <button type="submit" class="btn btn-w-icon btn-primary mt-2 me-2">
                <i class="fa-solid fa-fw fa-check me-1"></i>
                بروزرسانی
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-w-icon btn-outline-primary mt-2 me-2">
                <i class="fa-solid fa-fw fa-list-check me-1"></i>
                برگشتن
            </a>
        </div>
    </form>
</div>
@endsection
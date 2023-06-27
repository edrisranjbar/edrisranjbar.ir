@section('title', 'ایجاد نوشته جدید')
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">ایجاد نوشته جدید</h1>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <form class="w-100 p-3 bg-white rounded shadow-sm border" action="{{ route('posts.store') }}" method="POST"
        enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">محتوا</label>
                    <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                    @error('content')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex flex-wrap mt-2">
                    <button type="submit" class="btn btn-w-icon btn-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-check me-1"></i>
                        ثبت
                    </button>
                    <a class="btn btn-w-icon btn-outline-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-list-check me-1"></i>
                        ثبت و ساخت جدید
                    </a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="w-100 p-3 bg-white rounded shadow-sm border">
                    <div class="mb-3">
                        <label for="slug" class="form-label">شناسه یکتا</label>
                        <input name="slug" type="text" class="form-control" id="slug" pattern="[a-zA-Z]+" maxlength="50"
                            min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">وضعیت</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="public">عمومی</option>
                            <option value="private">خصوصی</option>
                            <option value="draft">پیش‌نویس</option>
                        </select>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">تصویر بند انگشتی</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                        @error('thumbnail')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="categories" class="form-label">دسته‌بندی‌ها</label>
                        <select name="categories[]" id="categories" class="form-select" multiple>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">برچسب‌ها</label>
                        <input type="text" name="tags" id="tags" class="form-control"
                            placeholder="برچسب ۱, برچسب ۲, برچسب ۳">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('title', isset($portfolio) ? 'ویرایش نمونه کار' : 'ایجاد نمونه کار جدید')
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">{{ isset($portfolio) ? 'ویرایش نمونه کار' : 'ایجاد نمونه کار جدید' }}</h1>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <form class="w-100 p-3 bg-white rounded shadow-sm border"
        action="{{ isset($portfolio) ? route('portfolios.update', $portfolio) : route('portfolios.store') }}"
        method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8">
                @csrf
                @if(isset($portfolio))
                @method('PUT')
                @endif
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ isset($portfolio) ? $portfolio->title : old('title') }}" required>
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">توضیحات</label>
                    <textarea name="description" id="description" class="form-control" rows="5"
                        required>{{ isset($portfolio) ? $portfolio->description : old('description') }}</textarea>
                    @error('description')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex flex-wrap mt-2">
                    @if (isset($portfolio))
                    <button type="submit" class="btn btn-w-icon btn-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-check me-1"></i>
                        بروزرسانی
                    </button>
                    <a href="{{ route('portfolios.index') }}" class="btn btn-w-icon btn-outline-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-list-check me-1"></i>
                        برگشتن
                    </a>
                    @else
                    <button type="submit" class="btn btn-w-icon btn-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-check me-1"></i>
                        ثبت
                    </button>
                    <a href="{{ route('portfolios.create') }}" class="btn btn-w-icon btn-outline-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-list-check me-1"></i>
                        ثبت و ساخت جدید
                    </a>
                    @endif
                </div>

            </div>
            <div class="col-lg-4">
                <div class="w-100 p-3 bg-white rounded shadow-sm border">
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">تصویر بند انگشتی</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                        @error('thumbnail')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">وضعیت</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="public" {{ (isset($portfolio) && $portfolio->status === 'public') ||
                                old('status') === 'public' ? 'selected' : '' }}>عمومی</option>
                            <option value="private" {{ (isset($portfolio) && $portfolio->status === 'private') ||
                                old('status') === 'private' ? 'selected' : '' }}>خصوصی</option>
                            <option value="draft" {{ (isset($portfolio) && $portfolio->status === 'draft') ||
                                old('status') === 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                        </select>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
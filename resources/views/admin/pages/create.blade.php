@section('title', isset($page) ? 'ویرایش صفحه' : 'ایجاد صفحه جدید')
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">{{ isset($page) ? 'ویرایش صفحه' : 'ایجاد صفحه جدید' }}</h1>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <form class="w-100 p-3 bg-white rounded shadow-sm border"
        action="{{ isset($page) ? route('pages.update', $page->id) : route('pages.store') }}" method="POST">
        @csrf
        @if (isset($page))
        @method('PUT')
        @endif
        <div class="row">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ isset($page) ? $page->title : old('title') }}" required>
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">محتوا</label>
                    <textarea name="content" id="content" class="form-control" rows="5"
                        required>{{ isset($page) ? $page->content : old('content') }}</textarea>
                    @error('content')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex flex-wrap mt-2">
                    @if (isset($page))
                    <button type="submit" class="btn btn-w-icon btn-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-check me-1"></i>
                        بروزرسانی
                    </button>
<button type="button" class="btn btn-w-icon btn-outline-danger mt-2 me-2" data-bs-toggle="modal"
                        data-bs-target="#deletePageModal">
                        <i class="fa-solid fa-fw fa-trash me-1"></i>
                        حذف
                    </button>
                    @else
                    <button type="submit" class="btn btn-w-icon btn-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-check me-1"></i>
                        ثبت
                    </button>
                    <a href="{{ route('pages.create') }}" class="btn btn-w-icon btn-outline-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-list-check me-1"></i>
                        ثبت و ساخت جدید
                    </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="w-100 p-3 bg-white rounded shadow-sm border">
                    <div class="mb-3">
                        <label for="slug" class="form-label">شناسه یکتا</label>
                        <input name="slug" type="text" class="form-control" id="slug" pattern="[a-zA-Z]+" maxlength="50"
                            required value="{{ isset($page) ? $page->slug : old('slug') }}">
                        @error('slug')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">نویسنده</label>
                        <select name="author" id="author" class="form-select" required>
                            @foreach ($authors as $author)
                            <option value="{{ $author->id }}" {{ (isset($page) && $page->author == $author->id) ?
                                'selected' : '' }}>
                                {{ $author->fullName }}</option>
                            @endforeach
                        </select>
                        @error('author')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Delete Page Modal -->
<div class="modal fade" id="deletePageModal" tabindex="-1" role="dialog" aria-labelledby="deletePageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="deletePageModalLabel">
                    تأیید حذف
                </h5>
                <button type="button" class="close close mr-auto ml-0" data-bs-dismiss="modal" aria-label="بستن">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>آیا از حذف این صفحه اطمینان دارید؟</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">انصراف
                </button>
                <form action="{{ route('pages.destroy', ['page' => $page->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
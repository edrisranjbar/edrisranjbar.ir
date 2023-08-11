@if(!isset($tutorial))
@section('title', 'ایجاد دوره جدید')
@else
@section('title', 'ویرایش دوره ' . $tutorial->title)
@endif
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">
        @if(!isset($tutorial))
        ایجاد آموزش جدید
        @else
        {{ $tutorial->title }}
        @endif
    </h1>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <form class="w-100 p-3 bg-white rounded shadow-sm border"
        action="{{ route('tutorials.update', ['tutorial'=>$tutorial->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $tutorial->title }}"
                        required>
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">توضیحات</label>
                    <textarea name="description" id="description" class="form-control"
                        rows="5">{{ $tutorial->description }}</textarea>
                    @error('description')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex flex-wrap mt-2">
                    <button type="submit" class="btn btn-w-icon btn-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-check me-1"></i>
                        ذخیرۀ تغییرات
                    </button>
                    <button type="button" class="btn btn-w-icon btn-outline-danger mt-2 me-2"
                        data-bs-toggle="modal" data-bs-target="#deleteTutorialModal">
                        <i class="fa-solid fa-fw fa-trash me-1"></i>
                        حذف
                    </button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="w-100 p-3 bg-white rounded shadow-sm border">
                    <div class="mb-3">
                        <label for="slug" class="form-label">شناسه یکتا</label>
                        <input name="slug" type="text" class="form-control" id="slug" pattern="[a-zA-Z]+" maxlength="50"
                            min="1" value="{{ $tutorial->slug }}" required>
                        @error('slug')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">وضعیت</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="public" {{ $tutorial->status === 'public' ? 'selected' : '' }}>عمومی</option>
                            <option value="private" {{ $tutorial->status === 'private' ? 'selected' : '' }}>خصوصی
                            </option>
                            <option value="draft" {{ $tutorial->status ===' draft' ? 'selected' : '' }}>پیش‌نویس
                            </option>
                        </select>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tutor" class="form-label">مدرس</label>
                        <select name="tutor" id="tutor" class="form-select" required>
                            @foreach ($tutors as $tutor)
                            <option value="{{ $tutor->id }}" {{ $tutorial->tutor == $tutor->id ? 'selected' : '' }}>{{
                                $tutor->fullName }}</option>
                            @endforeach
                        </select>
                        @error('tutor')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">قیمت</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="{{ $tutorial->price ?? 0 }}" min="0" required>
                        @error('price')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">مدت زمان (دقیقه)</label>
                        <input type="number" name="duration" id="duration" class="form-control" min="0"
                            value="{{ $tutorial->duration }}" required>
                        @error('duration')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">تصویر بند انگشتی</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control" @if(!isset($tutorial))
                            required @endif>
                        @error('thumbnail')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        @if ($tutorial->thumbnail)
                        <div class="mt-2">
                            <label class="form-label">تصویر فعلی:</label>
                            <img src="{{ asset('storage/upload/'.$tutorial->thumbnail) }}" class="img-fluid rounded">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Delete Tutorial Modal -->
<div class="modal fade" id="deleteTutorialModal" tabindex="-1" role="dialog" aria-labelledby="deleteTutorialModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="deleteTutorialModalLabel">
                    تأیید حذف
                </h5>
                <button type="button" class="close close mr-auto ml-0" data-bs-dismiss="modal" aria-label="بستن">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>آیا از حذف این دوره اطمینان دارید؟</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">انصراف
                </button>
                <form action="{{ route('tutorials.destroy', ['tutorial' => $tutorial->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
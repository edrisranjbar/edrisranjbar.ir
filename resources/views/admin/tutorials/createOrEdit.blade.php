@if(!isset($tutorial))
@section('title', 'ایجاد دوره جدید')
@else
@section('title', 'ویرایش دوره ' . $tutorial->title)
@endif
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">
        {{ !isset($tutorial) ? 'ایجاد آموزش جدید' : $tutorial->title }}
    </h1>
    <form class="w-100 p-3 bg-white rounded shadow-sm border"
        @if(isset($tutorial))
        action="{{ route('tutorials.update', ['tutorial'=> $tutorial->id]) }}"
        @else
        action="{{ route('tutorials.store') }}"
        @endif
        method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($tutorial))
        @method('patch')
        @endif
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ isset($tutorial) ? $tutorial->title : '' }}" required>
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">توضیحات</label>
                    <textarea name="description" id="description" class="form-control"
                        rows="5">{{ isset($tutorial) ? $tutorial->description : '' }}</textarea>
                    @error('description')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                @if(isset($form))
                <div class="d-flex flex-wrap">
                    <button class="btn btn-w-icon btn-primary mt-2 me-2" type="submit">
                        <i class="fa-solid fa-fw fa-edit me-1"></i>
                        ویرایش
                    </button>
                    <a class="btn bt-w-icon btn-outline-secondary mt-2 me-2" href="{{ route('form4.index') }}">
                        برگشت
                    </a>
                </div>
                @else
                <div class="d-flex flex-wrap">
                    <button class="btn btn-w-icon btn-primary me-2" type="submit">
                        <i class="fa-solid fa-fw fa-check me-1"></i>
                        ثبت
                    </button>
                    <a class="btn btn-w-icon btn-outline-primary me-2">
                        <i class="fa-solid fa-fw fa-list-check me-1"></i>
                        ثبت و ساخت جدید
                    </a>
                </div>
                @endif

            </div>
            <div class="col-12 col-lg-4">
                <div class="w-100 p-3 bg-white rounded shadow-sm border">
                    <div class="mb-3">
                        <label for="slug" class="form-label">شناسه یکتا</label>
                        <input name="slug" type="text" class="form-control" id="slug" maxlength="50" min="1"
                            value="{{ isset($tutorial) ? $tutorial->slug : '' }}" required>
                        @error('slug')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">مدت دوره</label>
                        <input type="number" name="duration" id="duration" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">هزینه شرکت در دوره</label>
                        <input type="number" name="price" id="price" class="form-control" required min="0" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">وضعیت</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="public" @if(isset($tutorial) && $tutorial->status === 'public') selected
                                @endif>عمومی
                            </option>
                            <option value="private" @if(isset($tutorial) && $tutorial->status === 'private') selected
                                @endif>خصوصی
                            </option>
                            <option value="draft" @if(isset($tutorial) && $tutorial->status === 'draft') selected
                                @endif>پیش‌نویس
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
                            <option value="{{ $tutor->id }}" @if(isset($tutorial) && $tutorial->tutor == $tutor->id) selected @endif>
                                {{ $tutor->fullName }}
                            </option>
                            @endforeach
                        </select>
                        @error('tutor')
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
                        @if (isset($tutorial) && $tutorial->thumbnail)
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
@if(isset($tutorial))
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
@endif

@stop
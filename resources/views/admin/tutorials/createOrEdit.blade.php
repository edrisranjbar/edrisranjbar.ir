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
    @include('templates.messages')
    <form class="w-100 p-3 bg-white rounded shadow-sm border" @if(isset($tutorial))
        action="{{ route('tutorials.update', ['tutorial'=> $tutorial->id]) }}" @else
        action="{{ route('tutorials.store') }}" @endif method="POST" enctype="multipart/form-data">
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

                {{-- Sections --}}
                <div class="mb-3">
                    <label for="sections" class="form-label">بخش ها</label>
                    <div id="sectionsGroup" class="form-check-group">
                        <!-- Existing sections loaded from the server -->
                        @forelse ($tutorial->sections ?? [] as $section)
                        <label class="form-check-label form-check">
                            <input name="sections[]" class="form-check-input" type="checkbox" value="{{ $section->id }}"
                                checked>
                            {{ $section->title }}
                            <button type="button" class="btn btn-sm btn-danger delete-section-btn"
                                data-section-id="{{ $section->id }}">حذف</button>
                        </label>
                        @empty
                        <label class="form-check-label form-check" id="sections-empty-state">
                            نتیجه ای یافت نشد
                        </label>
                        @endforelse
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-w-icon" id="addSectionBtn">
                        <i class="fa fa-solid fa-plus me-1"></i>
                        اضافه کردن بخش جدید
                    </button>
                </div>
                {{-- End Sections --}}

                @if(isset($tutorial))
                <div class="d-flex flex-wrap">
                    <button class="btn btn-w-icon btn-primary mt-2 me-2" type="submit">
                        <i class="fa-solid fa-fw fa-edit me-1"></i>
                        ویرایش
                    </button>
                    <a class="btn bt-w-icon btn-outline-secondary mt-2 me-2" href="{{ url('admin/tutorials') }}">
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
                        <input type="number" name="duration" id="duration" class="form-control" required min="1"
                            value="{{ $tutorial->duration ?? 0 }}">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">هزینه شرکت در دوره</label>
                        <input type="number" name="price" id="price" class="form-control" required min="0"
                            value="{{ $tutorial->price ?? 0 }}">
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
                            <option value="{{ $tutor->id }}" @if(isset($tutorial) && $tutorial->tutor == $tutor->id)
                                selected @endif>
                                {{ $tutor->fullName }}
                            </option>
                            @endforeach
                        </select>
                        @error('tutor')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="short_description" class="form-label">توضیحات کوتاه</label>
                        <textarea name="short_description" id="short_description" class="form-control"
                            rows="5">{{ isset($tutorial) ? $tutorial->short_description : '' }}</textarea>
                        @error('short_description')
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
                    <div class="mb-3">
                        <a href="#" class="btn btn-sm btn-outline-danger btn-w-icon d-inline-block"
                            data-bs-toggle="modal" data-bs-target="#deleteTutorialModal">
                            <i class="fa fa-solid fa-trash me-1"></i>
                            حذف
                        </a>
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
                <button type="button" class="btn-close ms-auto me-0" data-bs-dismiss="modal" aria-label="بستن">
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
                    <button type="submit" class="btn btn-danger btn-w-icon">
                        <i class="fa fa-solid fa-trash me-1"></i>
                        حذف
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Template for a new section -->
<template id="sectionTemplate">
    <label class="form-check-label form-check">
        <input name="newSections[]" class="form-check-input" type="checkbox" value="" checked>
        <span class="section-title"></span>
        <button type="button" class="btn btn-sm btn-outline-danger delete-section-btn btn-w-icon ms-auto" data-section-id="" onclick="deleteSection(this)">
            <i class="fa fa-solid fa-trash me-1"></i>
            حذف
        </button>
    </label>
</template>

<script src="{{ asset('assets/js/tutorials/createOrEdit.js') }}" defer></script>
@stop
@if(!isset($lesson))
@section('title', 'ایجاد درس جدید')
@else
@section('title', 'ویرایش درس ' . $lesson->title)
@endif
@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right" id="page-title">
        {{ !isset($lesson) ? 'ایجاد درس جدید' : $lesson->title }}
    </h1>
    @include('templates.messages')
    <form class="w-100 p-3 bg-white rounded shadow-sm border needs-validation"
        action="{{ isset($lesson) ? route('lessons.update', $lesson->id) : route('lessons.store') }}"
        method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @if(isset($lesson))
        @method('patch')
        @endif
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ isset($lesson) ? $lesson->title : '' }}" required>
                    <div class="invalid-feedback">
                        لطفا عنوان معتبری وارد کنید
                    </div>
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
                <h2 class="mt-4 h4">اطلاعات سئو</h2>
                <div class="mb-3">
                    <label for="seoTitle" class="form-label">عنوان سئو</label>
                    <input type="text" name="seoTitle" id="seoTitle" class="form-control" value="{{ isset($lesson) ? $lesson->seoTitle : '' }}"
                        required>
                    <div class="invalid-feedback">
                        لطفا عنوان معتبری وارد کنید
                    </div>
                    @error('seoTitle')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="seoDescription" class="form-label">توضیحات سئو</label>
                    <textarea name="seoDescription" id="seoDescription" class="form-control">{{ isset($lesson) ? $lesson->seoDescription : '' }}</textarea>
                    <div class="invalid-feedback">
                        لطفا توضیحات معتبری وارد کنید
                    </div>
                    @error('seoDescription')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                @if(isset($lesson))
                <div class="d-flex flex-wrap">
                    <button class="btn btn-w-icon btn-primary mt-2 me-2" type="submit">
                        <i class="fa-solid fa-fw fa-edit me-1"></i>
                        ویرایش
                    </button>
                    <a class="btn bt-w-icon btn-outline-secondary mt-2 me-2"
                    href="{{ url('admin/lessons') }}">
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
                            value="{{ isset($lesson) ? $lesson->slug : '' }}">
                        @error('slug')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="order_id" class="form-label">شماره درس</label>
                        <input name="order_id" type="number" class="form-control" id="order_id" max="1000" min="1"
                            value="{{ isset($lesson) ? $lesson->order_id : '' }}">
                        @error('order_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
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
                        <label for="duration" class="form-label">مدت درس</label>
                        <input type="number" name="duration" id="duration" class="form-control" required min="1"
                            value="{{ $tutorial->duration ?? 1 }}" aria-labelledby="durationDescription">
                        <p class="small text-muted">مدت درس را به ثانیه وارد کنید</p>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="isFree" name="isFree">
                        <label class="form-check-label ms-2" for="isFree">درس رایگان</label>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">فایل تمرین</label>
                        <div class="input-group">
                            <input type="file" name="file" id="file" class="form-control" accept=".zip">
                            <span class="input-group-text">
                                <i class="fa fa-solid fa-file-zipper"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">ویدیو</label>
                        <div class="input-group">
                            <input type="file" name="video" id="video" class="form-control" accept="video/*">
                            <span class="input-group-text">
                                <i class="fas fa-play-circle"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tutorial_id" class="form-label">دوره</label>
                        <select name="tutorial_id" id="tutorial_id" class="form-select" required>
                            <option selected disabled required>لطفا انتخاب کنید</option>
                            @foreach($tutorials as $tutorial)
                                <option value="{{ $tutorial->id }}" data-tutorialID="{{ $tutorial->id }}">
                                    {{ $tutorial->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('tutorial_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="section_id" class="form-label">بخش</label>
                        <select name="section_id" id="section_id" class="form-select" required>
                            <option selected disabled required>لطفا انتخاب کنید</option>
                            @foreach($sections as $section)
                            <option value="{{ $section->id }}" data-tutorialID="{{ $section->tutorial->id }}">{{ $section->title }}</option>
                            @endforeach
                        </select>
                        @error('section_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('assets/js/ckeditor.js') }}"></script>
<script>
    ClassicEditor
    .create(document.querySelector('#description'))
    .catch(error => {
        console.error(error);
    });
</script>
<script src="{{ asset('assets/js/lessons/createOrEdit.js') }}" defer></script>
@stop

@if(!isset($tutorial))
@section('title', 'ایجاد دوره جدید')
@else
@section('title', 'ویرایش دوره ' . $tutorial->title)
@endif
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right" id="page-title">
        {{ !isset($tutorial) ? 'ایجاد آموزش جدید' : $tutorial->title }}
    </h1>
    @include('templates.messages')
    <form class="w-100 p-3 bg-white rounded shadow-sm border needs-validation" @if(isset($tutorial))
        action="{{ route('tutorials.update', ['tutorial'=> $tutorial->id]) }}" @else
        action="{{ route('tutorials.store') }}" @endif method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @if(isset($tutorial))
        @method('patch')
        @endif
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ isset($tutorial) ? $tutorial->title : '' }}" required onkeyup="updatePageTitle()">
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

                <div class="mb-3">
                    <input type="hidden" name="good_for_items">
                    <label class="form-label">این دوره برای چه کسانی مناسب است؟</label>
                    <input type="text" id="goodForElement" name="good_for" class="form-control mb-2">
                    <ul class="list-group" id="goodForItems">
                        @foreach($tutorial->getGoodForItems() ?? [] as $item)
                        @if($item === "") @continue @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $item ?? "" }}</span>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-w-icon"
                            onclick="removeItemFromGoodForList(this)">
                                <i class="fa fa-solid fa-trash me-1"></i>
                                حذف
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>

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

                    <div class="mb-3 flex-column">
                        <label for="sectionName">بخش ها</label>
                        <div class="w-100 input-group">
                            <input id="sectionName" type="text" class="form-control rounded-start" placeholder="نام بخش را بنویسید" onkeypress="handlePressingEnterOnSectionNameElement(event)">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-w-icon" onclick="addNewSectionToSectionsList();">
                                <i class="fa fa-solid fa-plus me-1"></i>
                                افزودن
                            </button>
                        </div>
                        <ul id="sections" class="list-group my-2">
                            @foreach($tutorial->sections ?? [] as $section)
                                <li class="list-group-item">
                                    <div class='d-flex justify-content-between align-items-center'>
                                        {{ $section->title }}
                                        <button type='button' class='btn btn-sm btn-outline-danger btn-w-icon'
                                            onclick='removeSectionFromSectionsList(this)'>
                                            <i class='fa fa-solid fa-trash me-1'></i>
                                            حذف
                                        </button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <input type="hidden" name="sections" id="sectionsArray" value="{{ isset($tutorial) ? implode(', ', $tutorial->sections->pluck('title')->toArray()) : '' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="duration" class="form-label">مدت دوره</label>
                        <input type="number" name="duration" id="duration" class="form-control" required min="1"
                            value="{{ $tutorial->duration ?? 0 }}">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">هزینه شرکت در دوره</label>
                        <input type="number" name="price" id="price" class="form-control money" required min="0"
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
                        <label for="poster" class="form-label">پوستر</label>
                        <input type="file" name="poster" id="poster" class="form-control" @if(!isset($tutorial))
                            required @endif>
                        @error('poster')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        @if (isset($tutorial) && $tutorial->poster)
                        <div class="mt-2">
                            <label class="form-label">پوستر فعلی:</label>
                            <img src="{{ asset('storage/upload/'.$tutorial->poster) }}"
                            class="img-fluid rounded">
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

<script src="{{ asset('assets/js/ckeditor.js') }}"></script>
<script>
    ClassicEditor
    .create(document.querySelector('#description'))
    .catch(error => {
        console.error(error);
    });
</script>
<script src="{{ asset('assets/js/tutorials/createOrEdit.js') }}" defer></script>
@stop
@section('title', !isset($tutorial) ? 'ایجاد دوره جدید' : 'ویرایش دوره')
@extends('layouts.admin')
@section('content')
    <div class="container-lg text-black">
        @include('templates.messages')
        <form class="w-100 p-3 bg-white rounded shadow-sm border needs-validation"
              action="{{ isset($tutorial) ? route('tutorials.update', ['tutorial'=> $tutorial->id]) : route('tutorials.store') }}"
              method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @if(isset($tutorial))
                @method('patch')
            @endif
            <div class="row">
                <div class="col-12 col-lg-8">

                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان</label>
                        <input type="text" name="title" id="title" class="form-control"
                               value="{{ old('title', isset($tutorial) ? $tutorial->title : '') }}" required>
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
                                  rows="5">{{ old('description', isset($tutorial) ? $tutorial->description : '') }}</textarea>
                        @error('description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="hidden" name="good_for_items">
                        <label for="goodForElement" class="form-label">این دوره برای چه کسانی مناسب است؟</label>
                        <input type="text" id="goodForElement" name="good_for" class="form-control mb-2">
                        <ul class="list-group" id="goodForItems">
                            @foreach(isset($tutorial) ? $tutorial->getGoodForItems() ?? [] : [] as $item)
                                @if($item === "")
                                    @continue
                                @endif
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
                    <div class="mb-3">
                        <input type="hidden" name="bad_for_items">
                        <label for="badForElement" class="form-label">این دوره برای چه کسانی مناسب نیست؟</label>
                        <input type="text" id="badForElement" name="bad_for" class="form-control mb-2">
                        <ul class="list-group" id="badForItems">
                            @foreach(isset($tutorial) ? $tutorial->getBadForItems() ?? [] : [] as $item)
                                @if($item === "")
                                    @continue
                                @endif
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $item ?? "" }}</span>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-w-icon"
                                            onclick="removeItemFromBadForList(this)">
                                        <i class="fa fa-solid fa-trash me-1"></i>
                                        حذف
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div id="action-section" class="w-100 p-3 bg-white rounded border mb-3">
                        <div class="mb-3">
                            <label for="status" class="form-label fs-5">وضعیت</label>
                            <select name="status" id="status" class="form-select" required>
                                @foreach ($statusOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', isset($property) ? $property->status : '') === $value)>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            @error('status')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="d-flex flex-wrap mb-3">
                            @if(isset($tutorial))
                                <button class="btn btn-w-icon btn-primary mt-2 me-2" type="submit">
                                    <i class="fa-solid fa-fw fa-edit me-1"></i>
                                    ویرایش
                                </button>
                                <a href="#" class="btn btn-outline-danger btn-w-icon d-inline-block mt-2 me-2"
                                   data-bs-toggle="modal" data-bs-target="#deleteTutorialModal">
                                    <i class="fa fa-solid fa-trash me-1"></i>
                                    حذف
                                </a>
                            @else
                                <button class="btn btn-w-icon btn-primary me-2" type="submit">
                                    <i class="fa-solid fa-fw fa-check me-1"></i>
                                    ثبت
                                </button>
                                <button name="save_and_create_new" class="btn btn-w-icon btn-outline-primary me-2">
                                    <i class="fa-solid fa-fw fa-list-check me-1"></i>
                                    ثبت و ساخت جدید
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="w-100 p-3 bg-white rounded border">
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
                                <input id="sectionName" type="text" class="form-control rounded-start"
                                       placeholder="نام بخش را بنویسید"
                                       onkeyup="handlePressingEnterOnSectionNameElement(event)">
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-w-icon"
                                        onclick="addNewSectionToSectionsList();">
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
                            <input type="hidden" name="sections" id="sectionsArray"
                                   value="{{ isset($tutorial) ? implode(', ', $tutorial->sections->pluck('title')->toArray()) : '' }}">
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
                            <label for="tutor" class="form-label">مدرس</label>
                            <select name="tutor" id="tutor" class="form-select" required>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->id }}"
                                            @if(isset($tutorial) && $tutorial->tutor == $tutor->id)
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
                            <input type="file" name="thumbnail" id="thumbnail" class="form-control"
                                   @if(!isset($tutorial))
                                       required @endif>
                            @error('thumbnail')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                            @if (isset($tutorial) && $tutorial->thumbnail)
                                <div class="mt-2">
                                    <label class="form-label">تصویر فعلی:</label>
                                    <img src="{{ asset('storage/upload/'.$tutorial->thumbnail) }}"
                                         class="img-fluid rounded">
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
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Tutorial Modal -->
    @if(isset($tutorial))
        <div class="modal fade" id="deleteTutorialModal" tabindex="-1" role="dialog"
             aria-labelledby="deleteTutorialModalLabel"
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
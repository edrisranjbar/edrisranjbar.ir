@section('title', 'ویرایش نوشته')
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">ویرایش نوشته</h1>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <form class="w-100 p-3 bg-white rounded shadow-sm border" action="{{ route('posts.update', $post->id) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">محتوا</label>
                    <textarea name="content" id="content" class="form-control" rows="5"
                        required>{{ $post->content }}</textarea>
                    @error('content')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex flex-wrap mt-2">
                    <button type="submit" class="btn btn-w-icon btn-primary mt-2 me-2">
                        <i class="fa-solid fa-fw fa-check me-1"></i>
                        ذخیرۀ تغییرات
                    </button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="w-100 p-3 bg-white rounded shadow-sm border">
                    <div class="mb-3">
                        <label for="slug" class="form-label">شناسه یکتا</label>
                        <input name="slug" type="text" class="form-control" id="slug" pattern="[a-zA-Z]+" maxlength="50"
                            min="1" value="{{ $post->slug }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">وضعیت</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="public" @if($post->status == 'public') selected @endif>عمومی</option>
                            <option value="private" @if($post->status == 'private') selected @endif>خصوصی</option>
                            <option value="draft" @if($post->status == 'draft') selected @endif>پیش‌نویس</option>
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

                        @if ($post->thumbnail)
                        <div class="mt-2">
                            <label class="form-label">تصویر فعلی:</label>
                            <img src="{{ asset('storage/upload/'.$post->thumbnail) }}" class="img-fluid rounded">
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="categories" class="form-label">دسته‌بندی‌ها</label>
                        <select name="categories[]" id="categories" class="form-select" multiple>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if(in_array($category->id,
                                $post->categories->pluck('id')->toArray())) selected @endif>{{ $category->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">برچسب‌ها</label>
                        <input type="text" name="tags" id="tags" class="form-control"
                            placeholder="برچسب ۱, برچسب ۲, برچسب ۳"
                            value="{{ implode(', ', $post->tags->pluck('name')->toArray()) }}">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
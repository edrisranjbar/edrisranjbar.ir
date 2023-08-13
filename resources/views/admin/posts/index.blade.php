@section('title','نوشته ها')
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">لیست نوشته‌ها</h1>
    <div class="d-flex flex-wrap mb-2">
        <a class="btn btn-w-icon btn-primary mb-2 me-2" href="{{ route('posts.create') }}">
            <i class="fa-solid fa-fw fa-plus me-1"></i>
            افزودن نوشته جدید
        </a>
    </div>

    <div class="w-100 bg-white rounded shadow-sm table-responsive border">
        <table class="table table-striped table-clickable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">دسته بندی</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <th class="align-middle py-2" scope="row">{{ $loop->iteration }}</th>
                    <td class="align-middle py-2">{{ $post->title }}</td>
                    <td class="align-middle py-2">
                        @foreach($post->categories as $category)
                        <span class="badge py-2 px-2 text-bg-secondary">{{ $category->title }}</span>
                        @endforeach
                    </td>
                    <td class="align-middle py-2">{{ $post->status }}</td>
                    <td class="text-muted align-middle py-2">

                        <a href="{{ url('blog/' . $post->slug) }}"
                            class="btn btn-w-icon btn-outline-primary btn-sm float-left mr-2">
                            <i class="fa fa-eye ml-1"></i>نمایش
                        </a>
                        <a href="{{ route('posts.edit', $post->id) }}"
                            class="btn btn-w-icon btn-outline-secondary btn-sm float-left mr-2">
                            <i class="fa fa-edit ml-1"></i>ویرایش
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-3">نتیجه ای یافت نشد</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $posts->links('templates.pagination') }}
    </div>
</div>
@endsection
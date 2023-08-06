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
                    <th class="align-middle" scope="row">{{ $loop->iteration }}</th>
                    <td class="align-middle">{{ $post->title }}</td>
                    <td class="align-middle">
                        @foreach($post->categories as $category)
                        <span class="badge py-2 px-2 text-bg-secondary">{{ $category->title }}</span>
                        @endforeach
                    </td>
                    <td class="align-middle">{{ $post->status }}</td>
                    <td class="text-muted align-middle">
                        <a href="{{ route('posts.edit', $post->id) }}" class="text-muted btn btn-sm d-inline-block">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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
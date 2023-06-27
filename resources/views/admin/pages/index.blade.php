@section('title', 'صفحات')
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">لیست صفحات</h1>
    <div class="d-flex flex-wrap mb-2">
        <a class="btn btn-w-icon btn-primary mb-2 me-2" href="{{ route('pages.create') }}">
            <i class="fa-solid fa-fw fa-plus me-1"></i>
            افزودن صفحه جدید
        </a>
    </div>

    <div class="w-100 bg-white rounded shadow-sm table-responsive border">
        <table class="table table-striped table-clickable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">شناسه یکتا</th>
                    <th scope="col">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <th class="align-middle" scope="row">{{ $loop->iteration }}</th>
                    <td class="align-middle">{{ $page->title }}</td>
                    <td class="align-middle">{{ $page->slug }}</td>
                    <td class="text-muted align-middle">
                        <a href="{{ route('pages.edit', $page->id) }}" class="text-muted btn btn-sm d-inline-block">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm"
                                onclick="return confirm('مطمئنی میخوای این صفحه رو حذف کنی؟')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-3">نتیجه‌ای یافت نشد</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $pages->links('templates.pagination') }}
    </div>
</div>
@endsection
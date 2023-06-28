@section('title', 'Portfolios')
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">لیست نمونه کار ها</h1>
    <div class="d-flex flex-wrap mb-2">
        <a class="btn btn-w-icon btn-primary mb-2 me-2" href="{{ route('portfolios.create') }}">
            <i class="fa-solid fa-fw fa-plus me-1"></i>
            افزودن نمونه کار جدید
        </a>
    </div>

    <div class="w-100 bg-white rounded shadow-sm table-responsive border">
        <table class="table table-striped table-clickable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">توضیحات</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($portfolios as $portfolio)
                <tr>
                    <th class="align-middle" scope="row">{{ $loop->iteration }}</th>
                    <td class="align-middle">{{ $portfolio->title }}</td>
                    <td class="align-middle">{{ $portfolio->description }}</td>
                    <td class="align-middle">{{ $portfolio->status }}</td>
                    <td class="text-muted align-middle">
                        <a href="{{ route('portfolios.edit', $portfolio->id) }}"
                            class="text-muted btn btn-sm d-inline-block">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('portfolios.destroy', $portfolio->id) }}" method="POST"
                            class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm"
                                onclick="return confirm('مطمئنی میخوای این نمونه کار رو حذف کنی؟')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-3">نتیجه‌ای یافت نشد</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $portfolios->links('templates.pagination') }}
    </div>
</div>
@endsection
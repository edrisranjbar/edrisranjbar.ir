@extends('layouts.admin')
@section('title', 'لیست دوره‌ها')
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-wrap mb-2">
            <a class="btn btn-w-icon btn-dark mb-2 me-2" href="{{ route('tutorials.create') }}">
                <i class="fa-solid fa-fw fa-plus me-1"></i>
                افزودن دوره جدید
            </a>
        </div>
        @include('templates.messages')
        <div class="w-100 bg-white rounded shadow-sm table-responsive border">
            <table class="table table-striped table-clickable">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">قیمت</th>
                    <th scope="col">شرکت‌کنندگان</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col">بازدیدها</th>
                    <th scope="col">بازدیدکننده</th>
                    <th scope="col">عملیات</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($tutorials as $tutorial)
                    <tr>
                        <th class="align-middle py-2" scope="row">
                            {{ $loop->iteration }}
                        </th>
                        <td class="align-middle py-2">
                            <a href="{{ url('tutorials', $tutorial->slug) }}">{{ $tutorial->title }}</a>
                        </td>
                        <td class="align-middle py-2 money">{{ $tutorial->price }}</td>
                        <td class="align-middle py-2">
                            {{ $tutorial->students->count() }}
                        </td>
                        <td class="align-middle py-2">
                            <span class="p-2 badge badge-dark">{{ $tutorial->status_label }}</span>
                        </td>
                        <td class="align-middle py-2">{{ $tutorial->views }}</td>
                        <td class="align-middle py-2">{{ $tutorial->viewers }}</td>
                        <td class="d-flex justify-content-end gap-2 py-2">
                            <a href="{{ route('tutorials.edit', $tutorial->id) }}"
                               class="btn btn-w-icon btn-outline-secondary btn-sm">
                                <i class="fa fa-edit ml-1"></i>ویرایش
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">نتیجه ای یافت نشد</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
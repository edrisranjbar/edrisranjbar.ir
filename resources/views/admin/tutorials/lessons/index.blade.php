@extends('layouts.admin')

@section('title', 'لیست درس ها')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">لیست درس های آموزشی</h1>
    <div class="d-flex flex-wrap mb-2">
        <a class="btn btn-w-icon btn-primary mb-2 me-2"
        href="{{ route('lessons.create') }}">
            <i class="fa-solid fa-fw fa-plus me-1"></i>
            افزودن درس جدید
        </a>
    </div>
    @include('templates.messages')
    <div class="w-100 bg-white rounded shadow-sm table-responsive border">
        <table class="table table-striped table-clickable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">بخش و دوره</th>
                    <th scope="col">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lessons as $lesson)
                <tr>
                    <th class="align-middle py-2" scope="row">
                        <a href="{{ route('lessons.edit', $lesson) }}">
                            {{ $loop->iteration }}
                        </a>
                    </th>
                    <td class="align-middle py-2">
                        <a href="{{ route('lessons.edit', $lesson) }}">
                            {{ $lesson->title }}
                        </a>
                    </td>
                    <td class="align-middle py-2">
                        <a href="{{ route('lessons.edit', $lesson) }}">
                            بخش {{ $lesson->section->title }}،
                            دوره {{ $lesson->section->tutorial->title }}
                        </a>
                    </td>
                    <td class="align-middle py-2">
                        <a href="{{ url('tutorials/' . $lesson->section->tutorial->slug) }}"
                            class="btn btn-w-icon btn-outline-primary btn-sm float-left ms-2">
                            <i class="fa fa-eye ml-1"></i>نمایش دوره
                        </a>
                        <a href="{{ route('lessons.edit', $lesson->id) }}"
                            class="btn btn-w-icon btn-outline-secondary btn-sm float-left ms-2">
                            <i class="fa fa-edit ml-1"></i>ویرایش
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-3">نتیجه ای یافت نشد</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
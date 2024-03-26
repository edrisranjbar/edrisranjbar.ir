@extends('layouts.admin')
@section('title', 'لیست درس ها')
@section('content')
    <div class="container-fluid">
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
                    <th scope="col">دوره و بخش</th>
                    <th scope="col">مدت</th>
                    <th scope="col">عملیات</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($lessons as $lesson)
                    <tr>
                        <th class="align-middle py-2" scope="row">
                            {{ $loop->iteration }}
                        </th>
                        <td class="align-middle py-2">
                            <a href="{{ url($lesson->link) }}">
                                {{ $lesson->title }}
                            </a>
                        </td>
                        <td class="align-middle py-2">
                            <a href="{{ url($lesson?->section?->tutorial?->link ?? '#') }}">
                                دوره {{ $lesson->section->tutorial->title }}،
                                بخش {{ $lesson->section->title }}
                            </a>
                        </td>
                        <td class="align-middle py-2">
                            {{ $lesson->getDurationHumanReadable() }}
                        </td>
                        <td class="d-flex align-items-center gap-2 py-2">
                            <a href="{{ route('lessons.edit', $lesson->id) }}"
                               class="btn btn-w-icon btn-outline-primary btn-sm">
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
        </div>
    </div>
@endsection
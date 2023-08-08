@extends('layouts.admin')

@section('title', 'لیست دوره‌ها')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3 fw-normal text-right">لیست دوره‌های آموزشی</h1>
    <div class="d-flex flex-wrap mb-2">
        <a class="btn btn-w-icon btn-primary mb-2 me-2" href="{{ route('tutorials.create') }}">
            <i class="fa-solid fa-fw fa-plus me-1"></i>
            افزودن دوره جدید
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="w-100 bg-white rounded shadow-sm table-responsive border">
        <table class="table table-striped table-clickable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">قیمت</th>
                    <th scope="col">توضیحات</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tutorials as $tutorial)
                <tr>
                    <th class="align-middle py-2" scope="row">{{ $loop->iteration }}</th>
                    <td class="align-middle py-2">{{ $tutorial->title }}</td>
                    <td class="align-middle py-2">{{ $tutorial->price }}</td>
                    <td class="align-middle py-2">{{ $tutorial->description }}</td>
                    <td class="align-middle py-2">{{ $tutorial->status }}</td>
                    <td class="align-middle py-2">
                        <button type="button" class="btn btn-w-icon btn-outline-secondary btn-sm float-left mr-2"
                            data-bs-toggle="modal" data-bs-target="#deleteTutorialModal{{ $tutorial->id }}">
                            <i class="fa fa-trash ml-1"></i> حذف
                        </button>
                        <a href="{{ route('tutorials.edit', $tutorial->id) }}"
                            class="btn btn-w-icon btn-outline-secondary btn-sm float-left mr-2">
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
<!-- Delete Tutorial Modal -->
<div class="modal fade" id="deleteTutorialModal{{ $tutorial->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteTutorialModalLabel{{ $tutorial->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="deleteTutorialModalLabel{{ $tutorial->id }}">
                    تأیید حذف
                </h5>
                <button type="button" class="close close mr-auto ml-0" data-bs-dismiss="modal" aria-label="بستن">
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
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
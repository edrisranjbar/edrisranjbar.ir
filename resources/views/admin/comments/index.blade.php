@section('title', 'نظرات و پیشنهاد ها')
@extends('layouts.admin')
@section('content')
    <div class="container-lg px-md-5 px-4 text-right" dir="rtl">
        <div class="card shadow">
            <div class="card-body">
                @include('templates.messages')
                <div class="datatable-parent">
                    <table class="table text-nowrap table-striped table-bordered" id="comments-table">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th data-sortable="false">متن</th>
                            <th>وضعیت</th>
                            <th data-sortable="false">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($comments as $comment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    <a href='{{ url('admin/users/' . $comment->author_id) }}'>
                                        {{ $comment->author->name }}
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <span class="text-wrap">{!! $comment->message !!}</span>
                                    @if ($comment->reply_message)
                                        <br>
                                        <div class="comment_reply rounded shadow bg-light p-3 my-2">
                                            <i class="fa fa-reply ml-2"></i>
                                            <span class="text-wrap">{!! nl2br($comment->reply_message) !!}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('admin/comments/' . $comment->id . '/toggleApprovementStatus') }}">
                                            <span
                                                    class="badge badge-pill @if ($comment->confirmed) text-bg-success @else text-bg-secondary @endif p-2 cursor-pointer clickable-badge">
                                                @if ($comment->confirmed)
                                                    تایید شده
                                                @else
                                                    تایید نشده
                                                @endif
                                            </span>
                                    </a>
                                </td>
                                <td class="text-center align-middle">
                                    @if (!$comment->reply_message)
                                        <button class="btn btn-sm btn-outline-primary ml-2 btn-w-icon"
                                                onclick="openReplyModal(this,{{ $comment->id }})">
                                            <i class="fa fa-reply me-1"></i>
                                            ثبت پاسخ
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-outline-danger btn-w-icon" data-bs-toggle="modal"
                                                data-bs-target="#delete-comment-reply-modal"
                                                data-comment-id="{{ $comment->id }}">
                                            <i class="fa fa-trash me-1"></i>
                                            حذف پاسخ
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Reply Modal -->
    <div class="modal fade text-black" id="reply-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ثبت پاسخ</h5>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="reply-form">
                        @csrf
                        @method('PATCH')
                        <textarea name="reply_message" class="form-control"
                                  required>{{ old('reply_message') }}</textarea>
                    </form>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-primary" onclick="saveReply();">
                        <i class="fa fa-save me-1"></i>
                        ثبت
                    </button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-black" id="delete-comment-reply-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">حذف پاسخ</h5>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>مطمئنید می خواهید این پاسخ را حذف کنید</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">خیر، نمی خواهم</button>
                    <button class="btn btn-danger me-2" type="submit" id="modal-delete-comment-reply-btn">حذف کن
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="{{ asset('assets/js/admin/show-comments.js') }}" defer></script>
@endsection
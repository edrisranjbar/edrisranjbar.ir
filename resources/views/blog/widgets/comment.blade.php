@php
    use App\Helpers\AppHelper;
@endphp
<article class="p-3 bg-white rounded @if($isReply) reply @endif">
    <div class="d-flex justify-content-between align-items-center mb-2 relative">
        <div class="d-flex align-items-center">
            <p class="d-inline-flex align-items-center me-3 fs-5 fw-semibold text-dark">
                <img class="me-2 user-profile-photo" style="width: 50px; height: 50px;"
                     src="{{ $comment->author->profile_photo_src }}"
                     alt=" {{ $comment->author->name }}">
                {{ $comment->author->name }}
            </p>
            <p class="small text-muted">
                <time datetime="{{ $comment->updated_at->toIso8601String() }}"
                      title="{{ AppHelper::jdate('d F Y', strtotime($post->updated_at)) }}">
                    {{ AppHelper::jdate('d F Y', strtotime($post->updated_at)) }}
                </time>
            </p>
        </div>
    </div>
    <p class="text-dark my-0 mx-2">
        {{ $comment->message }}
    </p>

    @if(!$isReply)
        <button class="btn btn-sm btn-outline-primary btn-w-icon mb-3"
                data-bs-toggle="modal" data-bs-target="#reply-to-{{$comment->id}}-form">
            <i class="fa fas fa-reply me-1"></i>
            ثبت پاسخ
        </button>

        <div class="modal fade" tabindex="-1" aria-hidden="true" id="reply-to-{{$comment->id}}-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="flex-col card"
                          action="{{ url('comments') }}"
                          method="post">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{ $comment->id }}">
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <label for="reply-message-{{ $comment->id }}" class="sr-only">متن پاسخ</label>
                            <textarea id="reply-message-{{ $comment->id }}"
                                      class="form-control"
                                      placeholder="اینجا پاسخ دهید..." name="message"
                                      cols="30" rows="10"></textarea>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex gap-2 p-2">
                                <button class="btn btn-outline-primary btn-w-icon" type="submit">
                                    <i class="fa fas fa-send me-1"></i>
                                    ارسال
                                </button>
                                <button type="button" data-type="dismiss-reply-button"
                                        class="btn btn-outline-secondary">
                                    انصراف
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if(!empty($comment->reply_message))
        <div class="admin-reply-box border-1 bg-light text-dark py-3 px-2 rounded">
            <strong>پاسخ مدیر:</strong>&nbsp;
            {{ $comment->reply_message }}
        </div>
    @endif
    @foreach($comment->replies as $comment)
        @include('blog.widgets.comment',
            ['comment' => $comment, 'isReply' => true])
    @endforeach
</article>
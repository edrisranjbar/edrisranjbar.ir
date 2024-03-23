@php
    use App\Helpers\AppHelper;
@endphp
<article class="p-3 bg-white rounded">
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
    @if(!empty($comment->reply_message))
        <div class="admin-reply-box border-1 bg-light text-dark py-3 px-2 rounded">
            <strong>پاسخ:</strong>&nbsp;
            {{ $comment->reply_message }}
        </div>
    @endif
    @foreach($comment->replies as $comment)
        @include('blog.widgets.comment', $comment)
    @endforeach
</article>
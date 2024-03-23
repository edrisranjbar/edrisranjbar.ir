@php
    use Morilog\Jalali\Jalalian;
@endphp
@section('title', $post->title)
@section('header-class', 'bg-light')
@extends('layouts.app')
@section('content')
    <main class="container-lg text-light" id="blog-page">
        <div class="row">
            <div class="col-12">
                <article>
                    <header class="d-block mb-4">
                        <h1 class="fw-bolder mb-3">{{ $post->title }}</h1>
                        <div class="mb-2">
                            <span class="small">نویسنده: {{ $post->author->fullName }}</span>
                            <div class="small ms-1 mt-2">
                                آخرین به روزرسانی:
                                {{ Jalalian::fromDateTime($post->updated_at)->format('d F Y') }}
                            </div>
                        </div>
                    </header>
                    <figure class="mb-4">
                        <img class="w-75 rounded mx-auto d-block"
                             src="{{ asset('storage/upload/' . $post->thumbnail) }}"
                             alt="{{ $post->title }}">
                    </figure>
                    <section class="mb-5 fs-4 lh-md">
                        {!! $post->content !!}
                    </section>
                    <section class="d-flex flex-column" id="comments-section">
                        <div class="" id="comment-form">
                            @include('templates.messages')
                            <form method="post" action="{{ url('comments') }}" class="mb-5 d-flex flex-column gap-2">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <label for="message" class="fs-4 mb-2">متن پیام</label>
                                <textarea class="fs-5 form-control" name="message" id="message"
                                          cols="30" rows="10" required maxlength="255">{{ old('message') }}</textarea>
                                <button type="submit"
                                        class="btn btn-primary w-fit-content">
                                    ارسال نظر
                                </button>
                            </form>
                        </div>
                        <div id="comments">
                            @foreach($comments as $comment)
                                @include('blog.widgets.comment', $comment)
                            @endforeach
                        </div>
                    </section>
                </article>
            </div>

        </div>
    </main>
@stop
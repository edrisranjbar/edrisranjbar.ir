@php use Morilog\Jalali\Jalalian; @endphp
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
                </article>
            </div>

        </div>
    </main>
@stop
@section('title', $post->title)
@section('header-class', 'bg-light')
@extends('layouts.app')
@section('content')
    <main class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Post content-->
                <article>
                    <!-- Post header-->
                    <header class="mb-4">
                        <!-- Post title-->
                        <h1 class="fw-bolder mb-1">{{ $post->title }}</h1>
                        <!-- Post meta content-->
                        <div class="text-muted fst-italic mb-2">
                            {{ \Morilog\Jalali\Jalalian::fromDateTime($post->created_at)->format('d F Y') }}
                        </div>
                    </header>
                    <!-- Preview image figure-->
                    <figure class="mb-4">
                        <img class="img-fluid rounded mx-auto d-block"
                             src="{{ asset('storage/upload/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                    </figure>
                    <!-- Post content-->
                    <section class="mb-5 fs-4 lh-md">
                        {!! $post->content !!}}
                </section>
            </article>
        </div>

    </div>
</main>
@stop
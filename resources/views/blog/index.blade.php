@php use Morilog\Jalali\Jalalian; @endphp
@section('title', 'وبلاگ')
@extends('layouts.app')
@section('content')
<main class="container">
    <div class="col-md-8 offset-md-2 mb-5">
        <form action="{{ url('blog') }}" method="GET" class="input-group">
            <input type="text" name="search" class="form-control form-control-lg ms-sm-2"
                placeholder="مثلا: زبان های برنامه نویسی محبوب 2023"
                value="{{ strlen($searchQuery) > 0 ? $searchQuery : '' }}">
            <button type="submit" class="btn btn-primary my-2 my-sm-0">جست و جو</button>
        </form>
    </div>
    @if(strlen($searchQuery) === 0)
    <div class="p-4 p-md-5 m-4 rounded text-center text-bg-dark">
        <div class="col-12 px-0">
            <h1 class="display-6 mb-4 fw-bold text-primary">
                🎉 به روز ترین مقالات به شکلی روون و خوندنی
            </h1>
            <p class="lead my-3">
            سلام! من ادریس رنجبر هستم و اینجا قراره راجع به دنیای جذاب تکنولوژی و برنامه نویسی با هم صحبت کنیم. از آخرین اخبار دنیای تکنولوژی گرفته تا آموزش‌های عمیق برنامه نویسی، لینوکس و سرور. هدفم اینه که تجربیاتم رو به زبونی ساده و کاربردی با شما به اشتراک بذارم تا مسیر یادگیری و پیشرفتتون هموارتر بشه. پس اگه مثل من عاشق دنیای کدنویسی و تکنولوژی هستید، حتما این مطالب براتون جذاب خواهد بود.
            </p>
            <div class="d-inline-flex gap-2 my-3">
                <a href="#" class="d-inline-flex align-items-center btn btn-primary btn-lg px-4 rounded-pill">
                    <i class="fa fa-solid fa-arrow-left me-1"></i>
                    مقالات پربازدید
                </a>
                <a href="#" class="btn btn-outline-secondary btn-lg px-4 rounded-pill">
                    اخبار تکنولوژی
                </a>
            </div>
        </div>
    </div>
    @if(!$pinnedPosts->isEmpty())
    @include('blog.widgets.pinnedPostsSection')
    @endif
    @endif
    <h2 class="text-light ms-4 mt-5 mb-4">
        @if(strlen($searchQuery) === 0)
        ☕ جدیدترین مقالات
        @else
        🔍 نتیجه جست و جو
        @endif
    </h2>
    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-4 mb-4">
            <div class="card post animated-card">
                <a href="{{ $post->link }}" class="w-100">
                    <img src="{{ asset('storage/upload/' . $post->thumbnail) }}" class="card-img-top"
                        alt="{{ $post->title }}" loading="lazy">
                </a>
                <div class="card-body">
                    <div class="small text-muted text-right">
                        {{ Jalalian::fromDateTime($post->created_at)->format('d F Y') }}
                    </div>
                    <a href="{{ $post->link }}">
                        <h3 class="post-title">{{ $post->title }}</h3>
                    </a>
                    <p class="post-description card-text">{{ $post->excerpt }}</p>
                </div>
                <div class="card-footer w-100 border-0">
                    <a href="{{ $post->link }}" class="button button-sm text-dark button-outline-primary btn-w-icon">
                        <i class="fa fa-solid fa-eye me-1"></i>
                        ادامه مطلب
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 mb-4">
            <div class="card p-5 text-center">
                <img src="{{ asset('images/empty.svg') }}" alt="نتیجه ای یافت نشد" height="200px">
                <p class="h5 fw-normal my-3">
                    مقاله ای برای نمایش یافت نشد
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ url('/blog') }}" class="btn text-light btn-primary">
                        جست و جو رو بیخیال 😅
                    </a>
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-w-icon">
                        <i class="fa fa-solid fa-arrow-right me-1"></i>
                        برگرد صفحه اصلی
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</main>
@endsection
@section('title', 'وبلاگ')
@section('body-class', 'bg-light')
@extends('layouts.app')
@section('content')
<main class="container">

    <div class="col-md-8 offset-md-2 mb-5">
        <form action="" method="GET" class="input-group">
            <input type="text" name="query" class="form-control mr-sm-2" placeholder="جستجو...">
            <button type="submit" class="btn btn-primary my-2 my-sm-0">جستجو</button>
        </form>
    </div>

    <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
        <div class="col-12 px-0">
            <h1 class="display-6 fw-bold text-primary">
                به روز ترین مقالات حوزه برنامه نویسی
            </h1>
            <p class="lead my-3">
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است،
                چاپگرها و متون بلکه
                روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای
                متنوع با هدف بهبود
                ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و
                متخصصان را می طلبد، تا
                با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان
                فارسی ایجاد کرد، در
                این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و
                زمان مورد نیاز شامل
                حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار
                گیرد.
            </p>
            <p class="lead mb-0">
                <a href="#" class="fw-bold">
                    به خوندن ادامه بده...
                </a>
            </p>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-6">
            <div
                class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-2 text-primary">World</strong>
                    <h3 class="mb-0">Featured post</h3>
                    <div class="mb-1 text-muted">Nov 12</div>
                    <p class="card-text mb-auto">This is a wider card with supporting text below as a natural
                        lead-in to
                        additional content.</p>
                    <a href="#" class="stretched-link">Continue reading</a>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg"
                        role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice"
                        focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef"
                            dy=".3em">Thumbnail</text>
                    </svg>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div
                class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-2 text-success">Design</strong>
                    <h3 class="mb-0">Post title</h3>
                    <div class="mb-1 text-muted">Nov 11</div>
                    <p class="mb-auto">This is a wider card with supporting text below as a natural lead-in to
                        additional
                        content.</p>
                    <a href="#" class="stretched-link">Continue reading</a>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg"
                        role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice"
                        focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef"
                            dy=".3em">Thumbnail</text>
                    </svg>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Posts --}}
        @foreach ($posts as $post)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('storage/upload/' . $post->thumbnail) }}" class="card-img-top"
                    alt="{{ $post->title }}">
                <div class="card-body">
                    <div class="small text-muted">
                        {{ \Morilog\Jalali\Jalalian::fromDateTime($post->created_at)->format('d F Y') }}
                    </div>
                    <h5 class="card-title h4">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->excerpt }}</p>
                    <a href="{{ url('blog', $post->slug) }}" class="btn text-light btn-primary btn-w-icon">
                        <i class="fa fa-solid fa-eye me-1"></i>
                        ادامه مطلب
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</main>
@endsection
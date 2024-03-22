@php use Morilog\Jalali\Jalalian; @endphp
<h2 class="text-light ms-4 mt-5 mb-4">✨مقالات ویژه</h2>
<section class="row mb-2">
    @foreach($pinnedPosts as $post)
        <div class="col-md-6">
            <div class="card animated-card row g-0 px-0 border rounded overflow-hidden flex-md-row mb-4 position-relative bg-light">
                <div class="col p-4 d-flex flex-column position-static">
                    @if($post->categories?->first())
                        <strong class="d-inline-block badge text-bg-primary w-fit-content">
                            {{ $post->categories?->first()?->title }}
                        </strong>
                    @endif
                    <a href="{{ $post->link }}">
                        <h3 class="post-title mt-2 mb-1">{{ $post->title }}</h3>
                    </a>
                    <div class="mt-2 text-muted">
                        {{ Jalalian::fromDateTime($post->created_at)->format('d F Y') }}
                    </div>
                </div>
                <div class="col-6 d-none d-lg-block">
                    <a href="{{ $post->link }}">
                        <img style="max-height: 250px; width: 100%; aspect-ratio: 1 / 1; object-fit: cover;"
                             src="{{ asset('storage/upload/' . $post->thumbnail) }}"
                             alt="{{ $post->title }}">
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</section>
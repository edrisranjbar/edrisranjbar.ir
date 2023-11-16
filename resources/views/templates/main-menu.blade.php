<nav class="navbar navbar-expand-md">
    <a class="navbar-brand" href="{{ url('/') }}">
        <h1 class="h3 text-primary">ادریس رنجبر</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @foreach ($navbarItems as $navbarItem)
        <li class="nav-item {{ $navbarItem->route === url()->full() ? 'active' : '' }}">
            <a href="{{ url($navbarItem->route) }}">
                {{ $navbarItem->name }}
            </a>
        </li>
        @endforeach
    </ul>
    <button class="btn btn-primary">ورود / عضویت</button>
</nav>
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-3 me-md-auto text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="fs-4">Laravel</span>
    </a>

    <ul class="nav nav-pills me-md-5">
        <li class="nav-item">
            <a href="{{ route('post.index') }}"
                class="nav-link {{ Request::is('/') || Route::current()->getName() == 'post.index' ? 'active' : '' }}"
                aria-current="page">Tabela</a>
        </li>
        <li class="nav-item"><a href="{{ route('post.show') }}"
                class="nav-link  {{ Route::current()->getName() == 'post.show' ? 'active' : '' }}"">Wykres</a></li>
    </ul>
</header>

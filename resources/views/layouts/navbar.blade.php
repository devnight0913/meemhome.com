<nav class="navbar navbar-expand-lg navbar-dark shadow-sm bg-white" id="mainNavbar" style="z-index: 1025;">
    <div class="container">


        <a class="navbar-brand d-none d-md-block fw-bold" href="{{ route('home') }}">
            <img src="{{ asset('images/webp/meemhome-logo.webp') }}" alt="{{ config('app.name') }}"
                id="navbarBrandImage">
        </a>
        <button class="navbar-toggler ms-md-auto px-0" type="button" data-bs-toggle="offcanvas"
            href="#offcanvasCatalog" role="button" aria-controls="offcanvasCatalog">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="d-flex justify-content-center bg-white  align-items-center py-3 d-block d-md-none">
            <a href="{{ route('home') }}" class="fw-bold text-decoration-none h3">
                <img src="{{ asset('images/webp/meemhome-logo.webp') }}"  alt="{{ config('app.name') }}">
            </a>
        </div>

        <div class="d-flex align-items-center">
            <a class="nav-link ps-3 d-block d-md-none" href="{{ route('cart') }}">
                <div class="position-relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" style="width:1.5rem;height:1.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>

                    <cart-badge-component></cart-badge-component>
                </div>
            </a>
            {{-- <a href="tel:{{ config('app.phone_to_call') }}" class="nav-link ps-3 d-block d-md-none"
               >
                <i class="fa-solid fa-phone"></i>
            </a> --}}
            <a class="nav-link cursor-pointer ps-3 d-block d-md-none" data-bs-toggle="modal"
                data-bs-target="#searchModal">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="color:#3fa2b7; width:1.5rem; height:1.5rem;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </a>
            @guest
                <a href="{{ route('login') }}" class="nav-link ps-3 d-block d-md-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" style="color:#5687af; width:1.5rem; height:1.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </a>
            @endguest
            @auth
                <a class="nav-link ps-3 p-0  d-md-none d-block" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->profile_photo_url_small }}" alt="{{ Auth::user()->name }}"
                        class="profile-photo rounded-circle me-1" height="38">
                </a>
                <ul class="dropdown-menu rounded-4 end-0 animate slideIn shadow-sm" aria-labelledby="navbarDropdown">
                    @include('layouts.dropdown-items')
                </ul>
            @endauth
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">

                <li class="nav-item dropdown mt-md-0 mt-3">
                    <a class="nav-link" href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item dropdown mt-md-0 mt-3">
                    <a class="nav-link d-flex align-items-center" data-bs-toggle="offcanvas" href="#offcanvasCatalog"
                        role="button" aria-controls="offcanvasCatalog">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="hero-icon me-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg> Products
                    </a>
                </li>
                {{-- <li class="nav-item dropdown mt-md-0 mt-3">
                    <a class="nav-link" href="{{ route('services') }}">
                        Services
                    </a>
                </li> --}}
                <li class="nav-item dropdown mt-md-0 mt-3">
                    <a class="nav-link" href="{{ route('contact') }}">
                        Contact
                    </a>
                </li>
                <li class="nav-item dropdown mt-md-0 mt-3">
                    <a class="nav-link" href="{{ route('about') }}">
                        About
                    </a>
                </li>
                {{-- <li class="nav-item dropdown mt-md-0 mt-3">
                    <a class="nav-link bg-primary text-light px-4 rounded-pill" href="#" id="navbarDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d=flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="hero-icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            Catalog
                        </div>
                    </a>
                    <ul class="dropdown-menu rounded-4 animate slideIn shadow-sm p-0" aria-labelledby="navbarDropdown"
                        style="z-index: 1021;">
                        @foreach ($categories as $category)
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center" href="{{ $category->url }}">
                                    @if ($category->icon_url)
                                        <img src="{{ $category->icon_url }}" alt="{{ $category->name }}"
                                            class="me-2">
                                    @endif
                                    {{ $category->name }}
                                </a>
                            </li>
                            @if (!$loop->last)
                                <li>
                                    <hr class="dropdown-divider m-0">
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li> --}}

            </ul>
            <div class=" d-none d-md-block">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">


                    <li class="nav-item ps-2">
                        {{-- <a class="nav__icon nav-link cursor-pointer px-0" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" style="color:#3fa2b7; width:1.5rem;height:1.5rem;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </a> --}}
                        <form id="search_form" action="{{ route('search') }}">
                            <div class="form-group has-search-right">
                                <a href="#" onclick="event.preventDefault(); document.getElementById('search_form').submit()" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                <input type="text" class="form-control" placeholder="Search Products" name="search_query" id="search_query" value="{{ request('search_query') }}">
                            </div>
                        </form>
                    </li>

                    @guest
                        <li class="nav-item ps-2">
                            <a class="nav__icon nav-link px-0" href="{{ route('login') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" style="color:#5687af;width:1.5rem;height:1.5rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>

                            </a>
                        </li>
                    @endguest
                    <li class="nav-item ps-2">
                        <a class="nav__icon nav-link px-0 @if (Route::currentRouteName() == 'cart') active @endif"
                            href="{{ route('cart') }}">
                            <div class="position-relative">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" style="color:orange;width:1.5rem;height:1.5rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>

                                <cart-badge-component></cart-badge-component>
                            </div>
                        </a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link ps-3" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->profile_photo_url_small }}" alt="{{ Auth::user()->name }}"
                                    class="profile-photo rounded-circle me-1" height="38">
                                {{ Auth::user()->first_name }} <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" style="width:1.25rem;height:1.25rem;">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu rounded-0 dropdown-menu-md-end shadow-sm p-0"
                                aria-labelledby="navbarDropdown">
                                @include('layouts.dropdown-items')
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>

        </div>

    </div>
</nav>
<!--Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content"
            style="    backdrop-filter: saturate(180%) blur(10px);background-color: rgba(255, 255, 255, 0.4);">
            <div class="modal-header border-0">
                <button type="button" class="btn-close bg-white rounded-circle shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <form action="{{ route('search') }}" class="w-100">
                    <input type="search" name="search_query" id="search_query"
                        class="form-control form-control-lg w-100 text-center border-0 border-bottom rounded-0 shadow-none fs-1 mb-5"
                        placeholder="Search..." aria-label="Search" aria-describedby="button-addon2" required
                        maxlength="255" autocomplete="off" value="{{ request('search_query') }}"
                        style="background: 0 0;">
            </div>
            </form>
        </div>
    </div>
</div>



<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasCatalog" aria-labelledby="offcanvasCatalogLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasCatalogLabel">
            <img src="{{ asset('images/webp/meemhome-logo.webp') }}" 
                alt="{{ config('app.name') }}">
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @foreach ($categories as $category)
           <x-subcategory :category="$category" />
        @endforeach
        <hr />
        <a href="{{ route('home') }}"
            class="list-group-item list-group-item-action align-items-center py-2 d-flex text-uppercase fw-bold d-md-none d-block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hero-icon me-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Home
        </a>
        {{-- <a href="{{ route('services') }}"
            class="list-group-item list-group-item-action align-items-center py-2 d-flex text-uppercase fw-bold d-md-none d-block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hero-icon me-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
            </svg>

            Services
        </a> --}}
        <a href="{{ route('contact') }}"
            class="list-group-item list-group-item-action align-items-center py-2 d-flex text-uppercase fw-bold d-md-none d-block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hero-icon me-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
            </svg>

            Contact
        </a>
        <a href="{{ route('about') }}"
            class="list-group-item list-group-item-action align-items-center py-2 d-flex text-uppercase fw-bold d-md-none d-block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hero-icon me-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            About
        </a>
        @guest
            <a href="{{ route('login') }}"
                class="list-group-item list-group-item-action align-items-center py-2 d-flex text-uppercase fw-bold d-md-none d-block">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="hero-icon me-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>

                Login Or Signup
            </a>
        @endguest

    </div>
</div>

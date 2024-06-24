<nav class="navbar navbar-expand bg-light shadow-sm border-bottom">
    <div class="container-fluid">
        <a class="navbar-brand d-md-block d-none" href="{{ route('admin.dashboard') }}">  
            {{-- <img src="{{ asset('images/webp/logo.webp') }}" height="30" alt="{{ config('app.name') }}"> --}}
            <h1 class="admin__nav-title">Meemhome</h1>
        </a>
        <a class="navbar-brand d-block d-md-none" href="#">
            <button class="btn btn-link text-dark ps-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="hero-icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
                </svg>
            </button>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class=" hero-icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <notification-component></notification-component>
                </li>


                <li class="nav-item" id="full-screen-btn">
                    <a class="nav-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class=" hero-icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item d-none" id="default-screen-btn">
                    <a class="nav-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class=" hero-icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                        </svg>

                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link pt-1" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->profile_photo_url_small }}" alt="{{ Auth::user()->name }}"
                            height="30" class="rounded-circle border">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-0"
                        aria-labelledby="navbarDropdown">
                        @include('layouts.dropdown-items')
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>










@push('script')
    <script>
        var elemFull = document.querySelector('#full-screen-btn');
        var elemDefault = document.querySelector('#default-screen-btn');

        elemFull.addEventListener('click', function() {
            toggleFullScreen();
        });
        elemDefault.addEventListener('click', function() {
            toggleFullScreen();
        });

        function toggleFullScreen() {
            if ((document.fullScreenElement && document.fullScreenElement !== null) ||
                (!document.mozFullScreen && !document.webkitIsFullScreen)) {
                if (document.documentElement.requestFullScreen) {
                    document.documentElement.requestFullScreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullScreen) {
                    document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                }
                elemFull.classList.add('d-none');
                elemDefault.classList.remove('d-none');
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
                elemFull.classList.remove('d-none');
                elemDefault.classList.add('d-none');
            }
        }
    </script>
@endpush

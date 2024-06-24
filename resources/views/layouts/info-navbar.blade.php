<nav class="navbar navbar-expand navbar-light bg-body shadow-none d-none d-md-block small fw-bold" id="infoNavbar" style="z-index: 3">
    <div class="container">
        <ul class="navbar-nav me-auto">
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    Home
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact') }}">
                    Contact
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('about') }}">
                    About
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="tel:{{ $phoneValue }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        style="width:1.5rem;height:1.5rem;" class="me-1">
                        <path fill-rule="evenodd"
                            d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $phoneValue }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center">
                    |
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="mailto:{{ $emailValue }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        style="width:1.5rem;height:1.5rem;" class="me-1">
                        <path
                            d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                        <path
                            d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                    </svg>

                    {{ $emailValue }}
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('terms.show') }}">
                    Terms & Conditions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('privacy.show') }}">
                    Privacy Policy
                </a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link fs-7 ps-0" href="{{ config('app.location_to_go') }}" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="me-1"
                        style="width:1rem;height:1rem;">
                        <path fill-rule="evenodd"
                            d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"
                            clip-rule="evenodd" />
                    </svg>

                    {{ config('app.location') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-7" href="tel:{{ config('app.phone_to_call') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="me-1"
                        style="width:1rem;height:1rem;">
                        <path fill-rule="evenodd"
                            d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z"
                            clip-rule="evenodd" />
                    </svg> {{ config('app.phone') }}
                </a>
            </li> --}}
        </ul>
        <ul class="navbar-nav ms-auto">

            @if ($facebookUrl)
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="{{ $facebookUrl }}">
                        <i class="fa-brands fa-2x fa-facebook" style="color: #1778F2;"></i>
                    </a>
                </li>
            @endif

            @if ($instagramUrl)
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="{{ $instagramUrl }}">
                        <i class="fa-brands fa-2x fa-instagram" style="color: #111111;"></i>
                    </a>
                </li>
            @endif
            @if ($twitterUrl)
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="{{ $twitterUrl }}">
                        <i class="fa-brands fa-2x fa-twitter" style="color: #1DA1F2;"></i>
                    </a>
                </li>
            @endif
            @if ($youtubeUrl)
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="{{ $youtubeUrl }}">
                        <i class="fa-brands fa-2x fa-youtube" style="color: #FF0000;"></i>
                    </a> 
                </li>
            @endif
            @if ($tiktokUrl)
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="{{ $tiktokUrl }}">
                        <i class="fa-brands fa-2x fa-tiktok" style="color: #111111;"></i>
                    </a>
                </li>
            @endif
            @if ($whatsapp)
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="https://wa.me/{{ $whatsapp }}">
                        <i class="fa-brands fa-2x fa-whatsapp" style="color: #25d366;"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>

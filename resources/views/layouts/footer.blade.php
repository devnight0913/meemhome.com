<footer class="w-100 bg-dark">
    <!-- Grid container -->
    <div class="container p-4">
        <div class="row">
            <div class="col-md-6 col-lg-4 ps-lg-5 mb-4 mb-md-0">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/webp/meemhome-logo.webp') }}" height="100" alt="{{ config('app.name') }}"
                        class="mb-2">
                </a>
                {{-- <div class="mb-4 text-muted">
                    Description
                </div> --}}
                <div class="social-container">
                    <ul class="social-icons">
                        @if ($facebookUrl)
                            <li>
                                <a target="_blank" href="{{ $facebookUrl }}">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>
                            </li>
                        @endif

                        @if ($instagramUrl)
                            <li>
                                <a target="_blank" href="{{ $instagramUrl }}">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                        @endif
                        @if ($twitterUrl)
                            <li>
                                <a target="_blank" href="{{ $twitterUrl }}">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            </li>
                        @endif
                        @if ($youtubeUrl)
                            <li>
                                <a target="_blank" href="{{ $youtubeUrl }}">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            </li>
                        @endif
                        @if ($tiktokUrl)
                            <li>
                                <a target="_blank" href="{{ $tiktokUrl }}">
                                    <i class="fa-brands fa-tiktok"></i>
                                </a>
                            </li>
                        @endif
                        @if ($whatsapp)
                            <li>
                                <a target="_blank" href="https://wa.me/{{ $whatsapp }}">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>

            </div>
            <div class="col-md-6 col-lg-4 ps-lg-5 mb-4 mb-md-0">
                <div class="footer-heading ff-montserrat">Quick Links</div>
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('home') }}" class="link-primary text-white py-2 d-block">Home</a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('services') }}" class="link-primary text-white py-2 d-block">Services</a>
                    </li> --}}
                    <li>
                        <a href="{{ route('about') }}" class="link-primary text-white py-2 d-block">About Us</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="link-primary text-white py-2 d-block">Contact</a>
                    </li>

                    <li>
                        <a href="{{ route('terms.show') }}" class="link-primary text-white py-2 d-block">Terms &
                            Conditions</a>
                    </li>
                    <li>
                        <a href="{{ route('privacy.show') }}" class="link-primary text-white py-2 d-block">Privacy
                            Policy</a>
                    </li>

                </ul>
            </div>
            <div class="col-md-6 col-lg-4 ps-lg-5 mb-4 mb-md-0">
                <div class="footer-heading ff-montserrat">Have a Questions?</div>
                <ul class="list-unstyled">
                    @if ($address)
                        <li class="mb-4">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        style="width:1.5rem;height:1.5rem;color:#7aaa3c">
                                        <path fill-rule="evenodd"
                                            d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <a href="{{ $gmShareLink }}"
                                        class="link-primary text-white d-block">{{ $address }}</a>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if ($phone)
                        <li class="mb-4">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        style="width:1.5rem;height:1.5rem;color:#7aaa3c">
                                        <path fill-rule="evenodd"
                                            d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z"
                                            clip-rule="evenodd" />
                                    </svg>

                                </div>
                                <div>
                                    <a href="tel:{{ $phone }}"
                                        class="link-primary text-white d-block">{{ $phone }}</a>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if ($email)
                        <li class="mb-4">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        style="width:1.5rem;height:1.5rem;color:#7aaa3c">
                                        <path
                                            d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                                        <path
                                            d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                                    </svg>

                                </div>
                                <div>
                                    <a href="{{ $email }}"
                                        class="link-primary text-white d-block">{{ $email }}</a>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="mb-3 text-center">
        @if ($googlePlayUrl)
            <a href="{{ $googlePlayUrl }}" target="_blank" class="text-decoration-none">
                <img src="{{ asset('images/webp/google-play-button.webp') }}" class="mt-2 mt-md-0 mx-3"
                    style="height: auto; width: 180px; margin: 0px auto;">
            </a>
        @endif
        @if ($appStoreUrl)
            <a href="{{ $appStoreUrl }}" target="_blank" class="text-decoration-none mx-md-1">
                <img src="{{ asset('images/webp/app-store-button.webp') }}" class="mt-2 mt-md-0 mx-3"
                    style="height: auto; width: 180px; margin: 0px auto; cursor: pointer;">
            </a>
        @endif

    </div>

    @include('layouts.re-captcha')
    <!-- Grid container -->
    <div class="text-center text-light p-3" style="/*background-color: rgba(13, 24, 36, 0.2)*/">
        @include('layouts.copyright')
    </div>
</footer>
<!-- Footer -->
{{-- @push('script')
    <script>
        particlesJS.load('particals-footer', '/particles.json');
    </script>
@endpush --}}
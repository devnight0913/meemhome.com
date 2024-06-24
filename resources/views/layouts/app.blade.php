<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.gtag') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', "{{ config('app.gtag') }}");
    </script>
    <meta name="google-site-verification" content="{{ config('app.google_site_verification') }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="194x194" href="{{ asset('favicon-194x194.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    {{-- <link rel="manifest" href="{{ asset('site.webmanifest') }}"> --}}
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="Tech Center">
    <meta name="application-name" content="Tech Center">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('mstile-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

    <link rel="search" type="application/opensearchdescription+xml" href="/osd.xml" title="Title">
    @include('seotools.metatags')
    @include('seotools.opengraph')
    @include('seotools.twitter')
    @include('seotools.json-ld')
    <link rel="preload" href="{{ mix('css/app.css') }}" as="style" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @stack('style')
    @stack('head')
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '3820893768130236');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=3820893768130236&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
</head>

<body class="tech-body">

    <div class="tech-main" id="app">

        @include('layouts.info-navbar')
        @include('layouts.navbar')

        @yield('header')

        <div id="tech-wrapper" class="tech-wrapper">
            <div class="container py-3" id="app-container">
                @includeWhen(Route::currentRouteName() == 'home', 'layouts.global-alert')
                @includeWhen(Route::currentRouteName() == 'home', 'layouts.carousel')
                @include('alerts.show')
                @yield('content')
            </div>
        </div>
        @include('layouts.footer')


        <div class="bottom-0 m-3 end-0 position-fixed d-flex flex-column">
            <back-to-top-component></back-to-top-component>
            @if ($facebookMessenger)
                <a class="btn btn-lg text-white p-2 mb-2 messenger-chat rounded-circle d-flex align-items-center justify-content-center"
                    href="{{ $facebookMessenger }}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-title="Chat with us">

                    <svg fill="#ffffff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50px"
                        height="50px">
                        <path fill="none" stroke="#ffffff" stroke-miterlimit="10" stroke-width="2"
                            d="M25,3C12.85,3,3,12.178,3,23.5c0,6.366,3.114,12.054,8,15.814V47l7.516-3.906C20.566,43.682,22.743,44,25,44c12.15,0,22-9.178,22-20.5S37.15,3,25,3z" />
                        <path
                            d="M10.689 30.459L22.722 17.715 28.626 23.624 39.168 17.715 27.278 30.602 21.511 24.408z" />
                    </svg>
                </a>
            @endif
            @if ($whatsapp)
                <a class="btn btn-lg text-white p-2 whatsapp-chat rounded-circle d-flex align-items-center justify-content-center"
                    href="https://wa.me/{{ $whatsapp }}" target="_blank" data-bs-toggle="tooltip"
                    data-bs-placement="left" data-bs-title="Chat with us">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 32 32" width="32px" height="32px">
                        <g id="surface150026880">
                            <path style=" stroke:none;fill-rule:evenodd;fill:rgb(100%,100%,100%);fill-opacity:1;"
                                d="M 24.503906 7.503906 C 22.246094 5.246094 19.246094 4 16.050781 4 C 9.464844 4 4.101562 9.359375 4.101562 15.945312 C 4.097656 18.050781 4.648438 20.105469 5.695312 21.917969 L 4 28.109375 L 10.335938 26.445312 C 12.078125 27.398438 14.046875 27.898438 16.046875 27.902344 L 16.050781 27.902344 C 22.636719 27.902344 27.996094 22.542969 28 15.953125 C 28 12.761719 26.757812 9.761719 24.503906 7.503906 Z M 16.050781 25.882812 L 16.046875 25.882812 C 14.265625 25.882812 12.515625 25.402344 10.992188 24.5 L 10.628906 24.285156 L 6.867188 25.269531 L 7.871094 21.605469 L 7.636719 21.230469 C 6.640625 19.648438 6.117188 17.820312 6.117188 15.945312 C 6.117188 10.472656 10.574219 6.019531 16.054688 6.019531 C 18.707031 6.019531 21.199219 7.054688 23.074219 8.929688 C 24.949219 10.808594 25.980469 13.300781 25.980469 15.953125 C 25.980469 21.429688 21.523438 25.882812 16.050781 25.882812 Z M 21.496094 18.445312 C 21.199219 18.296875 19.730469 17.574219 19.457031 17.476562 C 19.183594 17.375 18.984375 17.328125 18.785156 17.625 C 18.585938 17.925781 18.015625 18.597656 17.839844 18.796875 C 17.667969 18.992188 17.492188 19.019531 17.195312 18.871094 C 16.894531 18.722656 15.933594 18.40625 14.792969 17.386719 C 13.90625 16.597656 13.304688 15.617188 13.132812 15.320312 C 12.957031 15.019531 13.113281 14.859375 13.261719 14.710938 C 13.398438 14.578125 13.5625 14.363281 13.710938 14.1875 C 13.859375 14.015625 13.910156 13.890625 14.011719 13.691406 C 14.109375 13.492188 14.058594 13.316406 13.984375 13.167969 C 13.910156 13.019531 13.3125 11.546875 13.0625 10.949219 C 12.820312 10.367188 12.574219 10.449219 12.390625 10.4375 C 12.21875 10.429688 12.019531 10.429688 11.820312 10.429688 C 11.621094 10.429688 11.296875 10.503906 11.023438 10.804688 C 10.75 11.101562 9.980469 11.824219 9.980469 13.292969 C 9.980469 14.761719 11.050781 16.183594 11.199219 16.382812 C 11.347656 16.578125 13.304688 19.59375 16.300781 20.886719 C 17.011719 21.195312 17.566406 21.378906 18 21.515625 C 18.714844 21.742188 19.367188 21.710938 19.882812 21.636719 C 20.457031 21.550781 21.648438 20.914062 21.898438 20.214844 C 22.144531 19.519531 22.144531 18.921875 22.070312 18.796875 C 21.996094 18.671875 21.796875 18.597656 21.496094 18.445312 Z M 21.496094 18.445312 " />
                        </g>
                    </svg>
                </a>
            @endif


        </div>
    </div>

    {{-- <div class="g-recaptcha" data-sitekey="6LdLm0QmAAAAALokfVhN0r5HpamqTo8bnxQlTxPM" data-size="invisible">
    </div> --}}
</body>

</html>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/particles.js') }}"></script>
<script src="{{ mix('js/common.js') }}"></script>
@stack('script')

<!DOCTYPE html>
<html lang="en" dir="ltr" translate="no">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="194x194" href="{{ asset('favicon-194x194.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="Tech Center">
    <meta name="application-name" content="Tech Center">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('mstile-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <title>{{ config('app.name') . ' Admin | ' }}@yield('title', config('app.name'))</title>
    <link rel="preload" href="{{ mix('css/app-admin.css') }}" as="style" />
    <link rel="stylesheet" href="{{ mix('css/app-admin.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.css" rel="stylesheet"></link>
    <link rel="stylesheet" href="{{ asset('css/admin-common.css')}}" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    @stack('head')
</head>

<body class="tech-body">
    {{-- <div id="app">
        <div class="d-flex" id="wrapper">
            @include('admin.layouts.sidebar-items')
            <div id="page-content-wrapper">
                @include('admin.layouts.navbar')
                <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
                    <div class="container-fluid">
                        <a class="navbar-brand text-decoration-none">@yield('page_name')</a>
                    </div>
                </nav>
                <div class="container-fluid py-3">

                    @include('alerts.show')
                    @yield('content')
                </div>
            </div>
        </div>
        <admin-back-to-top-component></admin-back-to-top-component>
    </div> --}}



    <div id="app" class="h-100">
        @include('admin.layouts.sidebar-items')
        <main class="tech-container">
            @include('admin.layouts.navbar')
            <div class="k-container container-fluid py-3">
                @include('alerts.show')
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/app-admin.js') }}"></script>
{{-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    if (Notification.permission !== "granted" && Notification.permission !== "denied") {
        Notification.requestPermission().then((permission) => {
            if (Notification.permission !== "granted") {
                Swal.fire("AVISO!", "Você não será notificado quando o pedido for enviado.", "warning");
            }
        });
    }

    //Pusher.logToConsole = true;
    var audio = new Audio("/audio/notification.mp3");

    var pusher = new Pusher('92ef70230747064d7406', {
        cluster: 'mt1'
    });

    var channel = pusher.subscribe('order-channel');
    channel.bind('order-event', function(data) {
        if (Notification.permission === "granted") {
            showNotification(data);
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then((permission) => {
                if (Notification.permission === "granted") {
                    showNotification(data);
                }
            });
        }
        audio.play();
        audio.loop = true;

        Swal.fire({
            title: data.message,
            text: "",
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: true,
            confirmButtonText: 'Ver Detalhes',
            cancelButtonText: 'Cancel',
            onClose: () => {
                audio.loop = false;
                audio.pause();
                audio.currentTime = 0;
            }
        }).then((result) => {
            if (result.value) {
                window.location.href = data.link;
            }
        });

    });

    function showNotification(data) {
        var title = "Narjes";
        var icon = "/images/notification-icon.png";
        var body = data.message;
        var notification = new Notification(title, {
            body,
            icon
        });
        notification.onclick = (e) => {
            window.location.href = data.link;
        };
    }
</script> --}}

@stack('script')

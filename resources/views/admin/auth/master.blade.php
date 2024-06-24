<!DOCTYPE html>
<html lang="en" dir="ltr" translate="yes">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preload" href="{{ mix('css/app-admin.css') }}" as="style" />
    <link rel="stylesheet" href="{{ mix('css/app-admin.css') }}">
    <style> html,body{height: 100%}</style>
    @stack('style')
</head>

<body class="container-login">
    <div class="container-fluid h-100" id="app">
        <div class="row h-100 justify-content-center align-items-center">
            @yield('content')
        </div>
    </div>

</body>

</html>
<script src="{{ asset('js/app.js') }}"></script>
@stack('script')

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('style')
    <style>
        body,
        html {
            height: 90%;
        }

        h1 {
            font-size: 150px;
            font-weight: 300
        }

        .text-shadow {
            text-shadow: 1px 2px 5px rgba(0, 0, 0, 1);
        }

    </style>

</head>

<body>
    <div class="container h-100">
        <div class="row h-100 text-center align-items-center">
            <div class="col-12">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
<script src="{{ mix('js/app.js') }}"></script>

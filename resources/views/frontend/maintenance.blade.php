<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 pt-5 text-center">
            <h3>
                Привет, Соня. Фронтенд я отключил, чтобы убересь твои глаза от недоделанной вёрстки.
            </h3>
            <img class="align-self-center" src="https://lh3.googleusercontent.com/proxy/xPo12Uu31ihtGBQIOv4JcLvZerjoH1J7mvdJOEfPP-r6WY7F-BgdBK0HyyNGcXPXdL5GyZ1qFvz1La2VeoawaYtK8BVdv3Jbm400jghAfTZyrZyjy-SJHl1YTV1yjTHOI5aIzRLH" alt="">
        </div>
    </div>
</div>
</body>

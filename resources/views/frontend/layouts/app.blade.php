<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Karandash') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.2.45/css/materialdesignicons.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        {{--user navigation vue component--}}
        <nav class="navbar">
            <ul class="nav nav-pills ml-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="#">Войти</a>
                </li>
                @endguest
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="#">Корзина</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Пункт 3</a>
                </li>
                @endauth
            </ul>
        </nav>
        {{--end user navigation vue component--}}

        {{--site navigation vue component--}}
        <site-navigation></site-navigation>
        {{--end site navigation vue component--}}

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

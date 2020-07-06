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
        <nav class="navbar">
            <div class="mr-auto"></div>
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link">Новинки</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Lalalala</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Babababa</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Nananana</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Mamamama</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Kakakaka</a>
                </li>
            </ul>
            <input class="ml-auto d-inline" type="text" placeholder="Поиск">
        </nav>
        {{--end site navigation vue component--}}

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    @stack('head')
    <!-- Scripts -->
    <script src="//code.iconify.design/1/1.0.6/iconify.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    @stack('scripts')
</head>
<body>
<div id="app" data-app class="frontend">
    <header>
        <div class="d-flex justify-content-end">
            <div id="header-top-wr">
                <div id="contacts">
                    <span class="contacts-title">Контакты</span>
                    <div>
                        <span class="mdi mdi-phone-outline"></span>
                        <span>+7 (4012) 52-21-11</span>
                    </div>
                    <div>
                        <span class="mdi mdi-email-open-outline"></span>
                        <span>mail@gorsad39.ru</span>
                    </div>
                    <div>
                        <span class="mdi mdi-clock-time-four-outline"></span>
                        <span>Пн-Пт 9.00 - 18.00</span>
                    </div>
                </div>
                <div id="user-links">
                    <span class="mdi mdi-magnify mdi-flip-h"></span>
                    <span class="mdi mdi-cart-outline"></span>
                    <span class="mdi mdi-account-outline"></span>
                </div>
            </div>
        </div>
        <div id="center">
            <x-frontend.logo></x-frontend.logo>
            <div id="search">
                <input type="text" name="" id="" placeholder="Поиск">
            </div>
        </div>
        <nav>
            <a class="nav-link" href="#">Каталог</a>
            <a class="nav-link" href="/services">Услуги</a>
            <a class="nav-link" href="#">Наши работы</a>
            <a class="nav-link" href="{{route('knowhow')}}">Советы</a>
            <a class="nav-link" href="{{route('design')}}">Дизайн</a>
            <a class="nav-link" href="#">Вакансии</a>
        </nav>
    </header>
    @yield('body')
    @yield('landing-form')
    <footer>
        <div id="footer-content" class="container-pd bg-white">
            <div class="footer-column">
                <x-frontend.logo></x-frontend.logo>
                <span class="w-75 mt-4">
                    Комплексное озеленение
                    и саженцы оптом в Калининграде
                    и области
                </span>
            </div>
            <div class="footer-column flex-grow-1">
                <span class="footer-col-title">Узнай больше</span>
                <span>Деревья</span>
                <span>Услуги</span>
                <span>Проекты</span>
                <span>Советы</span>
                <span>Дизайн</span>
            </div>
            <div class="footer-column">
                <span class="footer-col-title">Контакты</span>
                <div class="d-flex align-items-center">
                    <span class="footer-icon footer-icon-marker"></span>
                    <span>
                        ул. Еловая аллея, д26, Калининград,
                        Россия, 236038
                    </span>
                </div>
                <div class="d-flex">
                    <span class="footer-icon footer-icon-phone"></span>
                    <span>+7 (4012) 71-95-11</span>
                </div>
                <div class="d-flex">
                    <span class="footer-icon footer-icon-email"></span>
                    <span>Mail@gorsad39.ru</span>
                </div>

            </div>
            <div class="footer-column">
                <span class="footer-col-title">Оставайтесь в курсе новостей</span>
                <span>Подпишитесь на нашу рассылку</span>
                <input type="text" id="subscribe" placeholder="E-mail">
            </div>
        </div>
    </footer>
</div>
</body>
</html>

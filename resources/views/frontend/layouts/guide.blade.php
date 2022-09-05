<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="{{ asset('css/guide_page.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" data-app class="frontend">
    @yield('body')
</div>
</body>
</html>

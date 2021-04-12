<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

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
    <div id="app" class="frontend">
        <?php
        use Illuminate\Support\Facades\Auth;$auth_user = Auth::user()
        ?>
        <site-navigation @if(isset($auth_user)):auth_user="{{$auth_user}}" :user="{{json_encode($user)}}"@endif></site-navigation>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

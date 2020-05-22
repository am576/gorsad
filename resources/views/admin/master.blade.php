<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.2.45/css/materialdesignicons.min.css">

</head>
<body>
<div class="app-container">
    <div class="row content-container">
        <nav class="navbar navbar-default navbar-fixed-top navbar-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <ol class="breadcrumb hidden-xs">
                        <li class="active">
                            <a href="http://127.0.0.1:8000/admin"><i class="mdi mdi-home"></i> Панель управления</a>
                        </li>
                    </ol>
                </div>
                <ul class="nav navbar-nav  navbar-right ">

                <li>
                    <form action="http://127.0.0.1:8000/admin/logout" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="voyager-power"></i>
                            Выход
                        </button>
                    </form>
                </li>
                </ul>
            </div>
        </nav>
        <div class="side-menu sidebar">
            <ul class="nav navbar-nav">
                @foreach(config('admin.menu') as $menu_item)
                    <li>
                        <a href="{{ url('/admin/'.$menu_item['route']) }}">
                            <span class="mdi mdi-{{$menu_item['icon']}}"></span>
                            <span class="title">{{$menu_item['title']}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div id="app" class="container-fluid">
            <div class="side-body padding-top">
                @yield('page_header')
                @yield('content')
            </div>

        </div>
    </div>
</div>
</body>
</html>

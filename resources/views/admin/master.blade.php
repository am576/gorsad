<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gorsad - Панель администратора</title>

    <script src="{{ asset('js/admin.js') }}" defer></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>
<body>
<div id="app-admin" class="app-container">
    <div class="row content-container">
        <nav class="navbar navbar-default navbar-fixed-top navbar-top" style="background: #323443">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="dashboard-link" href="{{config('admin.url')}}"><i class="mdi mdi-home mdi-36px"></i></a>
                </div>
                <ul class="nav navbar-nav  navbar-right ">

                <li>
                    <form action="/admin/logout" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block" style="cursor:pointer;">
                            <i class="voyager-power"></i>
                            Выход
                        </button>
                    </form>
                </li>
                </ul>
            </div>
        </nav>
        <div id="sidemenu" class="side-menu sidebar">
            <ul class="nav navbar-nav" style="gap: 1rem">
                @foreach(config('admin.menu') as $menu_title => $menu_item)
                    <li>
                        <a href="{{ url('/admin/'.$menu_item['route']) }}">
                            <span id="{{$menu_title}}" class="mdi mdi-{{$menu_item['icon']}}" v-b-tooltip.hover.right="{ customClass: 'my-tooltip-class' }" title="{{Str::ucfirst($menu_item['title'])}}"></span>
{{--                            <span class="title">{{Str::ucfirst($menu_item['title'])}}</span>--}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div id="app" data-app class="w-100">
            <div class="side-body padding-top">
                @yield('page_header')
                <div class="page-content browse">
                    <div class="row">
                        <div class="col-md-12">
                            @yield('content')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>

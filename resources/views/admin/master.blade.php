<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

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
                    <button class="hamburger btn-link">
                        <span class="hamburger-inner"></span>
                    </button>
                    <ol class="breadcrumb hidden-xs">
                        <li class="active">
                            <a href="http://127.0.0.1:8001/admin"><i class="voyager-boat"></i> Панель управления</a>
                        </li>
                        <li>Products</li>
                    </ol>
                </div>
                <ul class="nav navbar-nav  navbar-right ">
                    <li class="dropdown profile">
                        <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown" role="button" aria-expanded="false"><img src="http://localhost:8000/storage/users/default.png" class="profile-img"> <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-animated">
                            <li class="profile-img">
                                <img src="http://localhost:8000/storage/users/default.png" class="profile-img">
                                <div class="profile-body">
                                    <h5>admin</h5>
                                    <h6>admin@karandash.zp.ua</h6>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="class-full-of-rum">
                                <a href="http://127.0.0.1:8001/admin/profile">
                                    <i class="voyager-person"></i>
                                    Профиль
                                </a>
                            </li>
                            <li>
                                <a href="/" target="_blank">
                                    <i class="voyager-home"></i>
                                    Главная
                                </a>
                            </li>
                            <li>
                                <form action="http://127.0.0.1:8001/admin/logout" method="POST">
                                    <input type="hidden" name="_token" value="OoQIko2UXpwVyt6f5x9p1EbkoS3ce9qYtt3vXAK6">
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="voyager-power"></i>
                                        Выход
                                    </button>
                                </form>
                            </li>
                        </ul>
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
    </div>
</div>
</body>
</html>

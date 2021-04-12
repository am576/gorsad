<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gorsad - Вход в Панель администратора</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.2.45/css/materialdesignicons.min.css">

</head>
<body>
<div class="container" style="margin-top:200px">
    <div class="row justify-content-center">
        <div class="row col-4 text-center">
            <form id="sign_in_adm" method="POST" action="{{ route('admin.login.submit') }}" style="padding: 20px;border-radius: 20px; background: #1f3339;">
                {{ csrf_field() }}
                <p class="text-light">Gorsad - панель администратора</p>
                <div class="form-group">
                    <span class="input-group-addon"> <i class="zmdi zmdi-account"></i> </span>
                    <div class="form-line">
                        <input id="login" type="text" class="form-control" name="login" placeholder="Логин"
                               value="{{ old('login') }}" required autofocus>
                    </div>
                    @error('login')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <span class="input-group-addon"> <i class="zmdi zmdi-lock"></i> </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Пароль" required>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary btn-raised waves-effect g-bg-cyan">Вход</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

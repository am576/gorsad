<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        #error-page {
            background: url('/storage/images/errorbackground-1.jpg') center no-repeat;
            background-size: cover;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
            flex-direction: column;
        }

        .position-ref {
            position: relative;
        }

        .code {
            font-size: 150px;
            color: #5bc86d;
        }

        .message {
            font-size: 28px;
            text-align: center;
        }
        a, a:visited, a:hover, a:active {
            color: #1b4b72;
        }
        .btn-wr {
            margin-top: 60px;
        }
        .button {
            padding: 10px 20px;
            border: 1px solid #1b4b72;
            border-radius: 20px;
            background-color: transparent;
            cursor: pointer;
            font-size: 20px;
            text-decoration: none;
        }
        .button:hover {
            background-color: #1b4b72;
            color: #fff;
            text-decoration: none;
        }

    </style>
</head>
<body>
<div id="error-page" class="flex-center position-ref full-height">
    <div class="code">
        @yield('code')
    </div>
    <div class="message" style="padding: 10px;">
        @yield('message')
    </div>
    <div class="btn-wr">
        <a class="button" href="/">На главную</a>
    </div>
</div>
</body>
</html>

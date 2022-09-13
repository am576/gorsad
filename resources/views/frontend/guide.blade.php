<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gorsad - Руководство</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="{{ asset('css/guide_page.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" data-app class="frontend">
    <div class="container-fluid">
        <guide-flipbook :image_names="{{$image_names}}"></guide-flipbook>
    </div>
</div>
</body>
</html>

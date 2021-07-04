<!DOCTYPE html>
<html>
<head>
    <title>Коммерческое предложение</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin: 0!important;padding: 0!important;">
<div style="width: 100%; max-width: 1200px; margin: auto; position: relative">
    <header>
        <div>
            <img class="header-bg" src="{{public_path().'/storage/images/pdf/header_bg.jpeg'}}" style="width: 100%">
            <img class="logo" src="{{public_path().'/storage/images/pdf/logo.png'}}" alt="">
        </div>
        <section class="header-info">
            <div class="company-title" style="display:table-cell; text-align: right; line-height: 20px">Городской садовник</div>
            <div style="text-transform: uppercase; width: 25%; font-size: 8px; font-weight: bold; display: table-cell">
                Компания по озеленению
                и благоустройству
                «Городской Садовник»
                г. Калининград,
                ул. Богатырская, д.35
            </div>
            <div style="text-transform: uppercase; width: 25%; font-size: 8px; font-weight: bold; display: table-cell">
                <span style="white-space: nowrap">ИНН 3906357100</span><br>
                <span style="white-space: nowrap">ОГРН 1173926022225</span><br>
                <span style="white-space: nowrap">Тел. 52-22-11</span><br>
                gorsad39.ru<br>
                info@group-zg.com<br>
            </div>
        </section>
    </header>
    <section>
        <h2 style="display:block; text-align: center">Коммерческое предложение</h2>
        <p style="font-size: 24px; display: block; padding-left: 25px;">
            От <span style="font-size: 18px">{{date('d.m.Y', strtotime($query->created_at))}}</span>
        </p>
        <div>
        <table class="table">
            <thead>
            <tr>
{{--                <th>№ п/п</th>--}}
                <th>Наименование</th>
                <th>Ед. изм</th>
                <th>Кол-во</th>
                <th>Цена, руб</th>
                <th>Сумма, руб</th>
            </tr>
            </thead>
            <tbody>
            @foreach($query->products() as $number => $product)
                <tr>
{{--                    <td>{{$number + 1}}</td>--}}
                    <td colspan="5">{{$product->title}}</td>
                </tr>
                @foreach ($product->variants as $variant)
                <tr>
{{--                    <td rowspan="{{count($product->variants)}}"></td>--}}
                    <?php
                    $variant->height = explode(',',$variant->height);
                    ?>
                    <td>{{$variant->type}} {{$variant->height[0]}} - {{$variant->height[1]}} м.</td>
                    <td>шт.</td>
                    <td>{{$variant->quantity}}</td>
                    <td>{{$variant->price}}</td>
                    <td>{{$variant->price * $variant->quantity}}</td>

                </tr>
                @endforeach
            @endforeach
            <tr>
                <td colspan="4">Итого, растения</td>
                <td><strong>{{$query->sumTotal()}}</strong></td>
            </tr>
            </tbody>
        </table>
        </div>
    </section>
    <footer style="margin-top: 150px">
        <div style="font-size: 16px; padding: 0 40px;">
            <span style="white-space: nowrap">С уважением,</span><br>
            <span style="white-space: nowrap">Рябоволов Андрей Юрьевич</span><br>
            <span style="white-space: nowrap">Руководитель отдела продаж компании по озеленению и благоустройству</span><br>
            <span style="white-space: nowrap">«Городской Садовник»</span><br>
            <span style="white-space: nowrap">г. Калининград, ул. Богатырская, 35</span><br>
            Тел. 52-22-11<br>
            E-mail: info@group-zg.com<br>
            Сайт: gorsad39.ru
        </div>
        <div style="text-align: center; padding: 0 40px;">
            <img class="logo" src="{{public_path().'/storage/images/pdf/footer_bg.png'}}" style="width: 100%; padding: 0 40px;">
        </div>
        <div style="text-align: center; font-size: 24px; padding: 20px 0;">
            Оптовые поставки деревьев и кустарников. Высадка. Уход
        </div>
    </footer>
</div>
</body>
<style>
    * {
        font-family: times !important;
    }
    html{
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
    }
    @media print {
        body {
            margin: 0 !important;
            padding:0 !important;
            border:0 !important;
            outline:0 !important;
        }
    }
    header {
        position: relative;
    }
    header .logo {
        position: absolute;
        left: 10px;
        top: 10px;
        height: 200px;
    }
    .header-bg {
        border-bottom: 5px solid #6abf83;
    }
    .header-info {
        display: table;
    }
    .header-info div {
        padding: 5px 25px;
    }
    .header-info .company-title{
        width: 60%;
        margin-left: 25%;
        font-size: 2rem;
        text-transform: uppercase;
        font-weight: bold;
    }
    .table {
        width: 70%;
        margin: 0 auto;
        border-collapse: collapse;
    }

    .table th, .table td {
        border: 1px solid #000000;
    }
    .table td {
        text-align: center;
    }

    footer {
        position: absolute;
        bottom: 0;
        left: 0;
    }

</style>
</html>

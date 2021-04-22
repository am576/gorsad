<!DOCTYPE html>
<html>
<head>
    <title>Счёт на оплату</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin: 0!important;padding: 0!important;">
<div style="width: 100%; max-width: 1200px; margin: auto; padding-top: 50px; position: relative">
    <header style="">
        <div  style="width: 100%;">
            <table class="table">
                <tbody>
                <tr>
                    <td colspan="4" style="font-size: 14px;">ФИЛИАЛ "САНКТ-ПЕТЕРБУРГСКИЙ" АО "АЛЬФА-БАНК"</td>
                </tr>
                <tr>
                    <td colspan="4">г. Санкт-Петербург</td>
                </tr>
                <tr>
                    <td colspan="4">Банк получателя</td>
                </tr>
                <tr>
                    <td width="25">ИНН</td>
                    <td width="25">3906357100</td>
                    <td width="25">КПП</td>
                    <td width="25">390601001</td>
                </tr>
                <tr>
                    <td colspan="4">ООО "Городской Садовник"</td>
                </tr>
                <tr>
                    <td colspan="4">Получатель</td>
                </tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                <tr>
                    <td>БИК</td>
                    <td>044030786</td>
                </tr>
                <tr>
                    <td>Сч. №</td>
                    <td>30101810600000000786</td>
                </tr>
                <tr>
                    <td>Сч. №</td>
                    <td>40702810032170003047</td>
                </tr>
                </tbody>
            </table>
        </div>
    </header>
    <section>
        <h2 style="display:block; padding-left: 50px; text-align: left">
            Счёт на оплату № {{sprintf('%08d', $order->id)}} от {{App\Utils\StaticTools::literalOrderDate($order->created_at)}}
        </h2>
        <table class="table">
            <tbody>
            <tr>
                <td>Поставщик (Исполнитель):</td>
                <td>ООО "Городской Садовник", ИНН 3906357100, КПП 390601001, 236029, Калининградская обл, Калининград г, Богатырская ул, дом № 35, офис 1, тел.: 89506742209</td>
            </tr>
            </tbody>
        </table>
        <table class="table" style="margin-top: 15px;">
            <tbody>
            <tr>
                <td>Покупатель (Заказчик):</td>
                <td>КЛГД СТРОЙ ООО, ИНН 3906262674, КПП 391701001, 236028, Калининградская обл, Гурьевский р-н, Шоссейное п, Калининградское шоссе ул, дом 8Б, квартира 4</td>
            </tr>
            </tbody>
        </table>
        <table class="table" style="margin-top: 15px">
            <thead>
            <tr>
                <th>№</th>
                <th style="text-align:center;">Товары (работы, услуги)</th>
                <th style="text-align:center;">Кол-во</th>
                <th style="text-align:center;">Ед.</th>
                <th style="text-align:right;">Цена</th>
                <th style="text-align: right;">Сумма</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products() as $index => $product)
                <tr>
                    <td>{{$index + 1}}</td>
                    <td style="text-align:center;">{{$product->custom_name == null ? $product->title : $product->custom_name}}</td>
                    <td style="text-align:center;">{{$product->quantity}}</td>
                    <td style="text-align:center;">шт.</td>
                    <td style="text-align:right;">{{$product->price}},00</td>
                    <td style="text-align: right;">{{$product->price * $product->quantity}},00</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" style="text-align: right;border: 0"><strong>Итого:</strong></td>
                <td style="text-align: right;border: 0"><strong>{{$order->sumTotal()}},00</strong></td>
            </tr>
            </tbody>
        </table>
        <table class="table" style="border:0; margin-top: 35px;">
            <tbody>
            <tr style="border:0;">
                <td style="border:0;">Руководитель</td>
                <td style="border:0;">Рябоволов А. Ю.</td>
                <td style="border:0;">Бухгалтер</td>
                <td style="border:0; text-align: right;">Рябоволов А. Ю.</td>
            </tr>
            </tbody>
        </table>
    </section>
    <footer>

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

    .table {
        width: 80%;
        margin: 0 auto;
        border-collapse: collapse;
    }

    .table th, .table td {
        border: 1px solid #000000;
    }
</style>
</html>

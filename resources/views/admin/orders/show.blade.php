@extends('admin.master')

@section('content')
    <?php
        $shops = [
            1 => 'Кнопочка',
            2 => 'Карандаш',
            3 => 'Дижон',
        ];
        $statuses = [
            'new' => 'Новый',
            'accepted' => 'В работе',
            'canceled' => 'Отменён',
            'closed' => 'Выполнен',
        ]
    ?>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body p-3">
                        <div class="row mb-2">
                            <div class="col-2 font-weight-bold">ID заказа</div>
                            <div class="col-4">{{sprintf('%08d', $order->id)}}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2 font-weight-bold">Сумма</div>
                            <div class="col-4">{{$order->sum_total}}.00 грн</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2 font-weight-bold">Доставка</div>
                            <div class="col-4">{{$shops[$order->delivery]}}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2 font-weight-bold">Статус</div>
                            <div class="col-4">{{$statuses[$order->status]}}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Заказчик</h5>
                                        <div class="card-subtitle mb-2 text-muted">Информация о покупателе</div>
                                        <div class="card-text">
                                            <div class="row">
                                                <div class="col-4">Имя</div>
                                                <div class="col-8">{{$order->client_name}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">Телефон</div>
                                                <div class="col-8">{{$order->client_phone}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Товары</h5>
                                        <div class="card-subtitle mb-2 text-muted">Список товаров</div>
                                        <div class="card-text">
                                            @foreach($order->products() as $index => $product)
                                            <div class="row">
                                                <div class="col-2">{{$index + 1}}.</div>
                                                <div class="col-10">{{$product->title}}</div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

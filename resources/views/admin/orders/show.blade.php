@extends('admin.master')

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body p-3">
                        <div class="row mb-2">
                            <div class="col-2 font-weight-bold">ID заказа</div>
                            <div class="col-4">0000001</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2 font-weight-bold">Сумма</div>
                            <div class="col-4">1000.00</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-2 font-weight-bold">Доставка</div>
                            <div class="col-4">Кнопочка</div>
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
                                                <div class="col-8">Василий Иванович</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">Телефон</div>
                                                <div class="col-8">0951231231</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Товары</h5>
                                        <div class="card-subtitle mb-2 text-muted">Список товаров</div>
                                        <div class="card-text">
                                            <div class="row">
                                                <div class="col-2">1.</div>
                                                <div class="col-10">{{App\Product::find(1)->title}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">2.</div>
                                                <div class="col-10">{{App\Product::find(4)->title}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">3.</div>
                                                <div class="col-10">{{App\Product::find(8)->title}}</div>
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
    </div>
@endsection

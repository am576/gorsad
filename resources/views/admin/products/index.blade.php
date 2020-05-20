@extends('admin.master')
@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Код товара</th>
                                    <th>Категория</th>
                                    <th>Цена</th>
                                    <th>Скидка</th>
                                    <th>Количество</th>
                                    <th>Статус</th>
                                    <th>Добавлен</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{$product->title}}</td>
                                        <td>{{$product->code}}</td>
                                        <td>{{$product->category_id}}</td>
                                        <td>{{$product->price}}</td>
                                        <td>{{$product->discount}}</td>
                                        <td>{{$product->quantity}}</td>
                                        <td>{{$product->status}}</td>
                                        <td>{{$product->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
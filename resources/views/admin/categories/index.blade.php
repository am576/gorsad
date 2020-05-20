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
                                    <th>Родит. категория</th>
                                    <th>Картинка</th>
                                    <th>Количество товаров</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{$product->title}}</td>
                                        <td>{{$product->parent_id}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

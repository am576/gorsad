@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                [
                    'entity' => 'order',
                    'mode' => 'index',
                    'with_buttons' => false
                ]
            )
@endsection
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
                                    <th>ID заказа</th>
                                    <th>Статус</th>
                                    <th class="text-right">Создан</th>
                                    <th class="text-right">Завершён</th>
                                    <th width="10"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>0000001</td>
                                    <td class="text-success">Закрыт</td>
                                    <td class="text-right">01.01.2019 14:54</td>
                                    <td class="text-right">31.12.2020 23:59</td>
                                    <td>
                                        <a class="btn btn-primary" href="/admin/orders/1">
                                            <i class="mdi mdi-arrow-right-bold mdi-18px"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

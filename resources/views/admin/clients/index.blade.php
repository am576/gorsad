@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                [
                    'entity' => 'client',
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
                                    <th>Имя</th>
                                    <th>Телефон</th>
                                    <th>Заказы</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Высилий Иванович</td>
                                    <td>0951231231</td>
                                    <td>
                                        <a href="#" onclick="alert('Заглушка')">Список заказов</a>
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

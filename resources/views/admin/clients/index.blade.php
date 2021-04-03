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
                                    <th>E-Mail</th>
                                    <th>Заказы</th>
                                    <th>Дата регистрации</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                <tr>
                                   <td>{{$client->name}}</td>
                                   <td>{{$client->email}}</td>
                                   <td></td>
                                   <td>{{$client->created_at}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

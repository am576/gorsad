@extends('admin.master')

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                            <h1 class="page-title">Предложения</h1>
                        </a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                            <h1 class="page-title">Заказы</h1>
                        </a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID предложения</th>
                                            <th>Клиент</th>
                                            <th>Статус</th>
                                            <th class="text-right">Создан</th>
                                            <th class="text-right">Завершён</th>
                                            <th width="10"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($queries as $query)
                                            <tr>
                                                <td>{{sprintf('%08d', $query->id)}}</td>
                                                <td>{{$query->user()->name}}</td>
                                                <td class="text-success">{{$query->status}}</td>
                                                <td class="text-right">{{$query->created_at}}</td>
                                                <td class="text-right">@if($query->status!='new'){{$query->updated_at}}@else&mdash;@endif</td>
                                                <td>
                                                    <a class="btn btn-primary" href="/admin/queries/{{$query->id}}">
                                                        <i class="mdi mdi-arrow-right-bold mdi-18px"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
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
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>{{sprintf('%08d', $order->id)}}</td>
                                                <td class="text-success">{{$order->status}}</td>
                                                <td class="text-right">{{$order->created_at}}</td>
                                                <td class="text-right">@if($order->status!='new'){{$order->updated_at}}@else&mdash;@endif</td>
                                                <td>
                                                    {{--<a class="btn btn-primary" href="/admin/orders/{{$order->id}}">
                                                        <i class="mdi mdi-arrow-right-bold mdi-18px"></i>
                                                    </a>--}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
        </div>
    </div>
@endsection

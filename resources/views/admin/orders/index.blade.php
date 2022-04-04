@extends('admin.master')

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-queries" role="tab" aria-controls="nav-home" aria-selected="true">
                            <h1 class="page-title">Запросы</h1>
                        </a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-orders" role="tab" aria-controls="nav-profile" aria-selected="false">
                            <h1 class="page-title">Заказы</h1>
                        </a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-services" role="tab" aria-controls="nav-profile" aria-selected="false">
                            <h1 class="page-title">Услуги</h1>
                        </a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-queries" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID запроса</th>
                                            <th>Клиент</th>
                                            <th>Статус</th>
                                            <th>PDF</th>
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
                                                <td>
                                                    <a href="{{'/admin/querypdf?user_id='.$query->user_id.'&query_id='.$query->id}}">
                                                        <span class="mdi mdi-file-document mdi-24px text-primary"></span>
                                                    </a>
                                                </td>
                                                <td class="text-right">{{date('d.m.Y', strtotime($query->created_at))}}</td>
                                                <td class="text-right">@if($query->status!='new'){{date('d.m.Y', strtotime($query->updated_at))}}@else&mdash;@endif</td>
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
                    <div class="tab-pane fade" id="nav-orders" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID заказа</th>
                                            <th>Клиент</th>
                                            <th>Статус</th>
                                            <th>PDF</th>
                                            <th class="text-right">Создан</th>
                                            <th class="text-right">Завершён</th>
                                            <th width="10"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>{{sprintf('%08d', $order->id)}}</td>
                                                <td>{{$order->user()->name}}</td>
                                                <td class="text-success">{{$order->status}}</td>
                                                <td>
                                                    <a href="{{'/admin/orderpdf?user_id='.$order->user_id.'&order_id='.$order->id}}">
                                                        <span class="mdi mdi-file-document mdi-24px text-primary"></span>
                                                    </a>
                                                </td>
                                                <td class="text-right">{{date('d.m.Y', strtotime($order->created_at))}}</td>
                                                <td class="text-right">@if($order->status!='new'){{date('d.m.Y', strtotime($order->updated_at))}}@else&mdash;@endif</td>
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
                    <div class="tab-pane fade show active" id="nav-services" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Имя</th>
                                            <th>Email</th>
                                            <th>Телефон</th>
                                            <th>Услуга</th>
                                            <th>Статус</th>
                                            <th>Дата</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $service_order_statuses = [
                                            'new' => [
                                                'class' => 'text-primary',
                                                'value' => 'новый'
                                            ],
                                            'complete' => [
                                                'class' => 'text-success',
                                                'value' => 'выполнен'
                                            ],
                                            'cancelled' => [
                                                'class' => 'text-danger',
                                                'value' => 'отменён'
                                            ]
                                        ]
                                        ?>
                                        @foreach($service_orders as $service_order)
                                            <tr>
                                                <td>{{$service_order->client_name}}</td>
                                                <td>{{$service_order->client_email}}</td>
                                                <td>{{empty($service_order->client_phone) ? '-' : $service_order->client_phone}}</td>
                                                <td>{{$service_order->service->name}}</td>
                                                <td class="{{$service_order_statuses[$service_order->status]['class']}}">{{$service_order_statuses[$service_order->status]['value']}}</td>
                                                <td>{{date('d.m.Y', strtotime($service_order->created_at))}}</td>
                                                @if($service_order->status == 'new')
                                                    <td>
                                                        <a class="btn btn-success" href="service_order/{{$service_order->id}}?status=complete" title="Выполнить">
                                                            <i class="mdi mdi-check mdi-18px"></i>
                                                        </a>
                                                        <a class="btn btn-danger" href="service_order/{{$service_order->id}}?status=cancelled" title="Отменить">
                                                            <i class="mdi mdi-close mdi-18px"></i>
                                                        </a>
                                                    </td>
                                                @endif
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

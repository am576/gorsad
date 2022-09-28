@extends('admin.master')
@section('content')
    <div class="dashboard">
        <div class="d-flex w-100 justify-content-between flex-nowrap" style="gap: 20px">
            <div class="font-weight-bold" style="height: 300px; width: 50%; background: #323544; color: white !important;">
                <h3 class="font-weight-bold" style="color: #eeeff8; padding: 1rem; background: #3b4052;">Недавние запросы</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Клиент</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($queries as $query)
                    <tr>
                        <td>{{$query->user()->name}}</td>
                        <td>{{$query->sumTotal()}}</td>
                        <td>{{$query->status}}</td>
                        <td>{!! date('d-m-y', strtotime($query->updated_at)) !!}</td>
                        <td>
                            <a href="{{'/admin/queries/'.$query->id}}">
                                <i class="mdi mdi-arrow-right-bold"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="font-weight-bold" style="min-height: 300px; width: 50%; background: #323544; color: white !important;">
                <h3 class="font-weight-bold" style="color: #eeeff8; padding: 1rem; background: #3b4052;">Недавние услуги</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Услуга</th>
                        <th>Клиент</th>
                        <th>Статус</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $service_order)
                        <tr>
                            <td>{{$service_order->service()->first()->name}}</td>
                            <td>{{$service_order->client_name}}</td>
                            <td>{{$service_order->status}}</td>
                            <td>{!! date('d-m-y', strtotime($service_order->updated_at)) !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

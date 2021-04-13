@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <nav class="col-4">
            <div class="nav nav-tabs flex-column"  id="nav-tab" role="tablist">
                <a class="nav-item nav-item nav-link active" data-toggle="tab" href="#profile_dashboard">МОЙ DASHBOARD</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#profile_queries">ПРЕДЛОЖЕНИЯ</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#profile_orders">ЗАКАЗЫ</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#profile_account">ЛИЧНЫЙ КАБИНЕТ</a>
            </div>
        </nav>
        <div class="tab-content col-8" id="nav-tabContent">
            <div class="tab-pane fade show active" role="tabpanel" id="profile_dashboard">
                <h1>ДОБРО ПОЖАЛОВАТЬ, {{$user->name}}</h1>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="profile_queries">
                <h4>Мои предложения</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Номер заказа</th>
                        <th>Дата</th>
                        <th>Количество</th>
                        <th>Статус</th>
                        <th>Файл</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user->queries as $query)
                        <tr>
                            <td>{{$query->id}}</td>
                            <td>{{date('d.m.y', strtotime($query->created_at))}}</td>
                            <td>{{$query->products_quantity()}}</td>
                            <td>{{$query->status}}</td>
                            <td>
                                <a href="{{$query->quote_file_link}}">
                                    <span class="mdi mdi-file-document"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="profile_orders">Мои заказы</div>
            <div class="tab-pane fade" role="tabpanel" id="profile_account">Личный кабинет</div>
        </div>
    </div>
</div>
@endsection

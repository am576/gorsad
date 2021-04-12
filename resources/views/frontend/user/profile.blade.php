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
            <div class="tab-pane fade" role="tabpanel" id="profile_queries">Мои предложения</div>
            <div class="tab-pane fade" role="tabpanel" id="profile_orders">Мои заказы</div>
            <div class="tab-pane fade" role="tabpanel" id="profile_account">Личный кабинет</div>
        </div>
    </div>
</div>
@endsection

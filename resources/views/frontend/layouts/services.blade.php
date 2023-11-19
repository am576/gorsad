@extends('frontend.layouts.master')
@section('title', 'Gorsad - Услуги')
@push('head')
    <link href="{{ asset('css/services.css') }}" rel="stylesheet">
@endpush
@section('body')
    <div id="services-page" class="body-bg">
        <div class="container-pd">
            @if(isset($heading))
                <nav class="page-menu">
                    <a href="/">Главная</a>
                    /
                    <a href="/services">Наши услуги</a>
                    /
                    <a href="/services/{{$service_group->id}}">{{$service_group->name}}</a>
                </nav>
            @endif
            <?php
                $title = isset($service_group) ? $service_group->name : 'Наши услуги';
            ?>
            <div class="heading">{{$heading ?? 'Наши услуги'}}</div>
        </div>
        @yield('content')
    </div>
@endsection
@section('landing-form')
    <div id="service-landing-form-wr">
        <div id="service-landing-form-inner" class="container-pd">
            <div id="landing-caption" class="heading text-white">
                Вы можете заказать у нас проект
            </div>
            <form action="" id="service-landing-form">
                <input type="text" placeholder="ФИО">
                <input type="text" placeholder="E-mail">
                <input type="text" placeholder="Телефон">
                <input type="text" placeholder="Комментарий">
                <button type="submit" class="btn-green no-border-radius">Отправить</button>
            </form>
        </div>
    </div>
@endsection

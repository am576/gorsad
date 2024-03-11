@extends('frontend.layouts.master')
@section('title', 'Gorsad - Услуги')
@push('styles')
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
            <form id="service-landing-form">
                <input type="text" name="name" placeholder="ФИО">
                <input type="text" name="email" placeholder="E-mail">
                <input type="text" name="phone" placeholder="Телефон">
                <input type="text" name="message" placeholder="Комментарий">
                <button type="button" class="btn-green no-border-radius" v-submit-form>Отправить</button>
            </form>
        </div>
    </div>
@endsection

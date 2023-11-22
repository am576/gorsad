@extends('frontend.layouts.master')
@section('title', 'Горсад - Советы')
@push('styles')
    <link href="{{ asset('css/knowhow.css') }}" rel="stylesheet">
@endpush
@section('body')
    <div id="knowhow-page" class="body-bg">
        <div class="container-pd">
            <div id="advices-menu-wr">
                <nav id="advices-menu">
                    <a href="{{route('planning')}}">Шаги посадки</a>
                    <a href="{{route('shape_trees')}}">Топиарные и формованные деревья</a>
                    <a href="{{route('trees_ordering')}}">Заказ деревьев</a>
                    <a href="/knowhow/tree-care">Уход за деревьями</a>
                </nav>
            </div>
            <nav class="page-menu">
                <a href="/">Главная</a>
                /
                <a href="/knowhow">Советы</a>
                @yield('current-page-link')
            </nav>
            <div id="top-banner" class="ppp">
                <div class="banner-left">
                    <div class="page-title">
                        @yield('page-title')
                    </div>
                    <div class="page-description">
                        @yield('page-description')
                    </div>
                </div>
                <div class="knowhow-main-image">
                    @yield('image')
                </div>
            </div>
            @yield('content')
        </div>
    </div>
@endsection

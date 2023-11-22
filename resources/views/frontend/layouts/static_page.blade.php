@extends('frontend.layouts.master')
@section('title', 'Горсад - Советы')
@push('styles')
    <link href="{{ asset('css/knowhow.css') }}" rel="stylesheet">
@endpush
@section('body')
    <div class="static-page body-bg">
        <div class="container-pd">
            <div id="menu-wr">
                <nav id="menu">
                    @yield('menu')
                </nav>
            </div>
            <nav class="page-menu">
                <a href="/">Главная</a>
                @yield('category-link')
                @yield('current-page-link')
            </nav>
            <div id="top-banner">
                <div class="banner-left @yield('banner-class')">
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
        @yield('body-bg')
    </div>
@endsection

@extends('frontend.layouts.master')
@section('title', 'Gorsad - Советы')
@push('styles')
    <link href="{{ asset('css/knowhow.css') }}" rel="stylesheet">
@endpush
@section('body')
    <div id="knowhow-page" class="body-bg">
        <div class="container-pd">
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

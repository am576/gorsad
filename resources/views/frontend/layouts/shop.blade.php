@extends('frontend.layouts.master')
@section('title', 'Горсад - Каталог')
@section('script_file', '')
@push('styles')
    <link href="{{ asset('css/catalog.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/shop.js') }}" defer></script>
@endpush

@section('body')
    <div class="catalog body-bg">
        <div class="container-pd">
            <nav class="page-menu">
                <a class="page-link-item" href="/">Главная</a>
                @yield('category-link')
                @yield('current-page-link')
            </nav>
        @yield('content')
    </div>
@endsection
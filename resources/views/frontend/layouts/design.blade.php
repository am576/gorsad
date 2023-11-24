@extends('frontend.layouts.static_page')
@section('title', 'Горсад - Дизайн')
@section('menu-class','design-menu')
@section('menu')
    <a href="{{route('outdoor_design')}}">Внешнее пространство</a>
    <a href="{{route('design_styles')}}">Стили ландшафтного дизайна</a>
    <a href="{{route('ecology')}}">Экология</a>
    <a href="{{route('roofs')}}">Кровли и контейнеры</a>
    <a href="{{route('street_profiles')}}">Улицы и аллеи</a>
    <a href="{{route('street_lighting')}}">Освещение</a>
@endsection
@section('category-link')
    /
    <a href="{{route('design')}}">Дизайн</a>
@endsection

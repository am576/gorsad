@extends('frontend.layouts.static_page')
@section('title', 'Горсад - Советы')
@section('menu')
    <a href="{{route('planning')}}">Шаги посадки</a>
    <a href="{{route('shape_trees')}}">Топиарные и формованные деревья</a>
    <a href="{{route('trees_ordering')}}">Заказ деревьев</a>
    <a href="/knowhow/tree-care">Уход за деревьями</a>
@endsection
@section('category-link')
    /
    <a href="/knowhow">Советы</a>
    @hasSection('current-page-link')
        /
    @endif
@endsection
@section('top-banner','1')

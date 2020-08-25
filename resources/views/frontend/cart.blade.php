@extends('frontend.layouts.app')
@section('title', 'Интернет-магазин канцтоваров "Карандаш"')
@section('content')
    <shopping-cart :cart_products="{{$cart}}"></shopping-cart>


@endsection

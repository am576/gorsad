@extends('frontend.layouts.app')
@section('title', 'Интернет-магазин канцтоваров "Карандаш"')
@section('content')
    <checkout-page :order_products="{{$order_products}}"></checkout-page>
@endsection

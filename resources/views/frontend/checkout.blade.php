@extends('frontend.layouts.app')
@section('title', 'Gorsad - оформление заказа')
@section('content')
    <checkout-page :order_products="{{$order_products}}"></checkout-page>
@endsection

@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
    <shopping-cart :cart_products="{{$cart}}"></shopping-cart>
@endsection

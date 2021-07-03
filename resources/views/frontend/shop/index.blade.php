@extends('frontend.layouts.shop')
@section('title', 'Gorsad')
@section('content')
    <shop-page :products_all="{{$products}}" :attributes="{{$attributes}}"></shop-page>
@endsection

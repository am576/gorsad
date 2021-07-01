@extends('frontend.layouts.shop')
@section('title', 'Gorsad')
@section('content')
    <shop-page :products="{{$products}}" :attributes="{{$attributes}}"></shop-page>
@endsection

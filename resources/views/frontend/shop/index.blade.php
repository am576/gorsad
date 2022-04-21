@extends('frontend.layouts.shop')
@section('title', 'Gorsad')
@section('content')
    <?php
    if(!isset($filtered_name)) {
        $filtered_name = '';
    }
    if(!isset($filter_options)) {
        $filter_options = '[]';
    }
    ?>
    <shop-page :products_all="{{$products}}" :attributes="{{$attributes}}" :filtered_name="{{"'".$filtered_name ."'" }}" :filter_options="{{$filter_options}}" :user="{{$user}}"></shop-page>
@endsection

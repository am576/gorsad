@extends('frontend.layouts.shop')
@section('title', 'Gorsad')
@section('category-link')
    /
    <a href="{{route('catalog')}}">Каталог</a>
@endsection
@section('content')
    <?php
    if(!isset($filtered_name)) {
        $filtered_name = '';
    }

    ?>
    <shop-page
        :products_all="{{$products}}"
        :attributes="{{$attributes}}"
        :filtered_name="{{"'".$filtered_name ."'" }}"
        :filter_options="{{$filter_options ?? '{}'}}"
        :user="{{$user}}"
        :show_banner="{{$showBanner}}">
    </shop-page>
@endsection

@extends('frontend.layouts.shop')
@section('title', 'Gorsad - ' . $product->title)
@section('category-link')
    /
    <a href="{{route('catalog')}}">Каталог</a>
    / {{$product->title}}
@endsection
@section('content')

<div>
    <product-page :product="{{$product}}"></product-page>
</div>
@endsection

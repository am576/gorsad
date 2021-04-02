@extends('frontend.layouts.app')
@section('title', $product->title)
@section('content')
<div class="container-fluid">
    <product-page :product="{{$product}}" :height="{{$product->height()}}":soil="{{$product->soil()}}" :speed="{{$product->speed()}}" :leaf_color="{{$product->leafColor()}}">

    </product-page>
</div>
@endsection

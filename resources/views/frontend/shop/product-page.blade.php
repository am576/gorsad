@extends('frontend.layouts.shop')
@section('title', 'Gorsad - ' . $product->title)
@section('content')

<div>
    <product-page :product="{{$product}}"></product-page>
</div>
@endsection

@extends('frontend.layouts.shop')
@section('title', 'Gorsad - ' . $product->title)
@section('content')

<div>
    <div>
        <product-page :product="{{$product}}"></product-page>
    </div>
    <div class="container-fluid mt-2" style="padding: 50px 0 !important; background: #434242">
        @if(count($product['images']))
        <product-images :product="{{$product}}"></product-images>
        @endif
    </div>
</div>
@endsection

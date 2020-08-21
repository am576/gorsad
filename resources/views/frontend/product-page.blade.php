@extends('frontend.layouts.app')
@section('title', $product->title)
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-6">
            <product-images :product="{{$product}}"></product-images>
        </div>
        <div class="col-6">
            <div style="border: 1px solid #2a9055; height: 100%"></div>
        </div>
    </div>
</div>
@endsection

@extends('frontend.layouts.app')
@section('title', $product->title)
@section('content')
<div class="container-fluid">
    <product-page :product="{{$product}}"></product-page>
</div>
@endsection

@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'product', 'mode' => 'edit'])
@endsection
@section('content')
    <product-edit-form :product="{{$product}}" :product_attributes="{{$product->attributes()}}" :product_images="{{$product->images}}"></product-edit-form>
    @method('put')
@endsection

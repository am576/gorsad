@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'product', 'mode' => 'edit'])
@endsection
@section('content')
    <product-edit-form :fields="{{$product}}" :product_attributes="{{$product->attributes()}}"></product-edit-form>
    @method('put')
@endsection

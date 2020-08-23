@extends('frontend.layouts.app')
@section('title', $product->title)
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-6">
            <product-images :product="{{$product}}"></product-images>
        </div>
        <div class="col-6">
            <div class="p-3" style="border: 1px solid #2a9055; height: 100% ">
                <h3>{{$product->title}}({{$product->code}})</h3>
                <div>{{$product->price}}.00 грн</div>
                <div>----</div>
                <div contenteditable="true">
                    {!!$product->description!!}
                </div>
                <button class="btn btn-primary" onclick="alert('Заглушка')">Купить</button>
            </div>
        </div>
    </div>
</div>
@endsection

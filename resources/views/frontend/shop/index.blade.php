@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 pr-5 pl-5">
            <div class="pt-3 border-bottom">
                <div class="row">
                    @foreach($products as $product)
                        <div style="width: 20%; padding: 10px">
                            <div class="product-card" style=" background-image: url({{'storage/images/'.$product->images[0]->medium}}">
                                <p class="description">{{$product->title}}</p>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

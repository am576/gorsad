@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 pr-5 pl-5">
            <div class="pt-3 border-bottom">
                <products-list :products="{{$products}}"></products-list>
            </div>
        </div>
        @if(!count($products))
            По вашему запросу ничего не найдено.
        @endif
    </div>
</div>
@endsection

@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 pr-5 pl-5">
            <home-slider></home-slider>
            <div class="row">
                <filter-small :filter_attributes="{{$filter_attributes}}"></filter-small>
            </div>
            <div class="pt-3 border-bottom">
            </div>
        </div>
    </div>
</div>
@endsection

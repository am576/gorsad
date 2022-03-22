@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid services-all">
    <div class="row justify-content-center bg-white">
        <div class="col-md-12 services-wrapper flex-column align-items-center">
            <services-page :service_groups="{{$service_groups}}"></services-page>
        </div>
    </div>
</div>
@endsection

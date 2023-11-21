@extends('frontend.layouts.services')
@section('title', 'Gorsad - Услуги | ' . $service_group->name)
@section('content')
    <div id="services-banner">
        <img src="/storage/images/{{$service_group->image}}" alt="">
    </div>
    <div class="body-bg">
        <div class="container-pd">
            <div class="service-group-description">
                {!! $service_group->description !!}
            </div>
            <div id="sg-services">
                <services-list :services="{{$service_group->services}}"></services-list>
            </div>
        </div>
    </div>
@endsection

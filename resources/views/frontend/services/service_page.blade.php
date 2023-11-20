@extends('frontend.layouts.services')
@section('title', 'Gorsad - Услуги | ' . $service_group->name)
@section('content')
    <div id="services-banner">
        <img src="/storage/images/{{$service_group->image}}" alt="">
    </div>
@endsection

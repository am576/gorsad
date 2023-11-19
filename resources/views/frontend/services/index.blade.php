@extends('frontend.layouts.services')
@section('title', 'Gorsad - Услуги')
@section('content')
<div id="services-banner">
    <img src="/storage/images/service_groups/services-banner.jpg" alt="">
</div>
    <div id="services-list" class="container-pd">
        @foreach($service_groups as $service_group)
            <a href="{{'services/'.$service_group->id}}">
                <div class="service-link">
                    <img src="{{'/storage/images/'.$service_group->images[0]['large']}}" alt="">
                    <span class="service-title">{{$service_group->name}}</span>
                </div>
            </a>
        @endforeach
    </div>
@endsection

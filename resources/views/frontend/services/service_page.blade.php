@extends('frontend.layouts.app')
@section('title', 'Gorsad | ' . $service_group->name)
@section('content')
    <service-page :service_group="{{$service_group}}"></service-page>
@endsection

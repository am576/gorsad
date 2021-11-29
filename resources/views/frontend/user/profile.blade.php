@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid layout-spacing">
    <user-profile :data="{{$user}}" :tab="{{$tabIndex ?? 0}}"></user-profile>
</div>
@endsection

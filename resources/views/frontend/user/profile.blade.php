@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid">
    <user-profile :data="{{$user}}"></user-profile>
</div>
@endsection

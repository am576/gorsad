@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid">
    <user-profile :data="{{$user}}" :tab="{{$tabIndex ?? 0}}"></user-profile>
</div>
@endsection

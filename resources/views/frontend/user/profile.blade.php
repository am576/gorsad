@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
    <?php
//        dd($tab)
    ?>
<div id="user-profile" class="container-fluid">
    <user-profile :data="{{$user}}" :tab="{{$tab ?? 'user_cabinet'}}"></user-profile>
</div>
@endsection

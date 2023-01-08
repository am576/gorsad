@extends('errors.layout')
@section('title', config('app.name').' - ' . 'Сессия устарела')
@section('code')
    419
@endsection
@section('message')
    Сессия устарела
@endsection


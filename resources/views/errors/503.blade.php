@extends('errors.layout')
@section('title', config('app.name').' - ' . 'Сервис недоступен')
@section('code')
    500
@endsection
@section('message')
    Сервис недоступен
@endsection


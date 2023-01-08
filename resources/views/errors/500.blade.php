@extends('errors.layout')
@section('title', config('app.name').' - ' . 'Ошибка сервера')
@section('code')
    500
@endsection
@section('message')
    Ошибка сервера
@endsection


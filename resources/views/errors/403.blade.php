@extends('errors.layout')
@section('title', config('app.name').' - ' . 'В доступе отказано')
@section('code')
    403
@endsection
@section('message')
    В доступе на страницу отказано
@endsection


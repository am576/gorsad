@extends('errors.layout')
@section('title', config('app.name').' - ' . 'Метод не разрешён')
@section('code')
    405
@endsection
@section('message')
    Метод не разрешён
@endsection


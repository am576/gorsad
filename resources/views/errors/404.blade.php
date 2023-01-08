@extends('errors.layout')
@section('title', config('app.name').' - ' . 'Страница не найдена')
@section('code')
    404
@endsection
@section('message')
    Запрашиваемая страница не найдена
@endsection


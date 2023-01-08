@extends('errors.layout')
@section('title', config('app.name').' - ' . 'Не аввторизован')
@section('code')
    403
@endsection
@section('message')
    Не аввторизован
@endsection


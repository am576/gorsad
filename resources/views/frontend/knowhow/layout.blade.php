@extends('frontend.layouts.app')
@section('title', 'Gorsad - Дизайн')
@section('content')
    @push('styles')
        <link href="{{ asset('css/knowhow.css') }}" rel="stylesheet">
    @endpush
    @yield('page')
@endsection

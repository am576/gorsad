@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'category', 'mode' => 'create'])
@endsection
@section('content')
    <category-form></category-form>
@endsection

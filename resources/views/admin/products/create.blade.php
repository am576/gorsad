@extends('admin.master')
@section('content')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'product', 'mode' => 'create'])
@endsection
<product-form></product-form>
@endsection

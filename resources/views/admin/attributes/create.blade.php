@extends('admin.master')
@section('content')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'attribute', 'mode' => 'create'])
@endsection
<attribute-form></attribute-form>
@endsection

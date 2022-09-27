@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'service', 'mode' => 'create'])
@endsection
@section('content')
<service-form></service-form>
@endsection

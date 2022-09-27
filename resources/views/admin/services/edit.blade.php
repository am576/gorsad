@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'service', 'mode' => 'edit'])
@endsection
@section('content')
<service-form :is_edit="true" :service_data="{{$service}}"></service-form>
@endsection

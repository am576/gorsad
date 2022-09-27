@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'service.submenu.service_group', 'mode' => 'edit'])
@endsection
@section('content')
<service-group-form :is_edit="true" :service_group_data="{{$service_group}}"></service-group-form>
@method('put')
@endsection

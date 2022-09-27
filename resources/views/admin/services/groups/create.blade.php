@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'service.submenu.service_group', 'mode' => 'create'])
@endsection
@section('content')
<service-group-form></service-group-form>
@endsection

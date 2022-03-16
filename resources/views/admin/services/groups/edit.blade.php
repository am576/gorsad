@extends('admin.master')
@section('content')
<service-group-form :is_edit="true" :service_group_data="{{$service_group}}"></service-group-form>
@method('put')
@endsection

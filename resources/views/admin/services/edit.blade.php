@extends('admin.master')
@section('content')
<service-form :is_edit="true" :service_data="{{$service}}"></service-form>
@endsection

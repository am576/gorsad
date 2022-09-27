@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'project', 'mode' => 'create'])
@endsection
@section('content')
<project-form></project-form>
@endsection

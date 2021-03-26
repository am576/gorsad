@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'attribute.submenu.1', 'mode' => 'edit'])
@endsection
@section('content')
<iconset-form :edit_form="{{true}}" :iconset_data="{{$iconset}}"></iconset-form>
@endsection

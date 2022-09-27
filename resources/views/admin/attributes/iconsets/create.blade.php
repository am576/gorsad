@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'attribute.submenu.icon_set', 'mode' => 'create'])
@endsection
@section('content')
<iconset-form></iconset-form>
@endsection

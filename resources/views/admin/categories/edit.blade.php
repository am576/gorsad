@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'category', 'mode' => 'edit'])
@endsection
@section('content')
<category-form :edit_form="true" :category_data="{{$category}}"></category-form>
@endsection

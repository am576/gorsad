@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'attribute', 'mode' => 'edit'])
@endsection
@section('content')
    <?php
//        dd($attribute);
    ?>
<attribute-form :is_edit_form="true" attribute_data="{{$attribute}}"></attribute-form>
@endsection

@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'project', 'mode' => 'edit'])
@endsection
@section('content')
    <?php
//        dd($project);
    ?>
    <project-form :is_edit="true" :project_data="{{$project}}"></project-form>
    @method('put')
@endsection

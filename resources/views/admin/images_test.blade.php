@extends('admin.master')
@section('page_header')
<div class="container-fluid">
    <h1 class="page-title">
       Images test
    </h1>
</div>
@endsection
@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <image-uploader></image-uploader>
            </div>
        </div>
    </div>
@endsection

@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                ['entity' => 'service',
                 'mode' => 'index',
                 'with_buttons' => true
                ]
            )
@endsection
@section('content')
    <div class="panel panel-bordered">
        <div class="panel-body">
            <services-table :services="{{$services}}"></services-table>
        </div>
    </div>
@endsection

@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                ['entity' => 'project',
                 'mode' => 'index',
                 'with_buttons' => true
                ]
            )
@endsection
@section('content')
    <div class="panel panel-bordered">
        <div class="panel-body">
            <projects-table :projects="{{$projects}}"></projects-table>
        </div>
    </div>
@endsection

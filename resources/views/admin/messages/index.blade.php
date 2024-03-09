@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                ['entity' => 'message',
                 'mode' => 'index',
                 'with_buttons' => false
                ]
            )
@endsection
@section('content')
    <div class="panel panel-bordered">
        <div class="panel-body">
            <messages-table></messages-table>
        </div>
    </div>
@endsection

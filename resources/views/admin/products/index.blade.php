@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                ['entity' => 'product',
                 'mode' => 'index',
                 'with_buttons' => true
                ]
            )
@endsection
@section('content')
    <div class="panel panel-bordered">
        <div class="panel-body">
            <products-table></products-table>
        </div>
    </div>
@endsection

@extends('admin.master')

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="card-header">
                        <h3>Запрос #{{sprintf('%08d', $query->id)}}</h3>
                    </div>
                    <div class="panel-body p-3">
                        <user-query-editor :query="{{$query}}" :data="{{$query->products()}}"></user-query-editor>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                [
                    'entity' => 'attribute',
                    'mode' => 'index',
                    'with_buttons' => true
                ]
            )
@endsection
@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Категория</th>
                                    <th>Название</th>
                                    <th>Значения</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($attributes as $attribute)
                                    <tr>
                                        <td>{{$attribute->category->title ?? '-'}}</td>
                                        <td>{{$attribute->name}}</td>
                                        <td>
                                            @foreach($attribute->values() as $value)
                                            {{$value->value}};
                                            @endforeach
                                        </td>
                                        <td>@include('admin.macros.table-buttons', ['entity' => $attribute])</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                [
                    'entity' => 'attribute.submenu.1',
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
                                    <th>Название</th>
                                    <th>Количество иконок</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($iconsets as $iconset)
                                    <tr>
                                        <td>{{$iconset->name ?? '-'}}</td>
                                        <td>{{}}</td>
                                        <td>@include('admin.macros.table-buttons', ['entity' => $iconset])</td>
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

@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                [
                    'entity' => 'attribute.submenu.icon_set',
                    'mode' => 'index',
                    'with_buttons' => true
                ]
            )
@endsection
@section('content')
    <div class="panel panel-bordered">
        <div class="panel-body">
            <div class="table-responsive">
                <table id="dataTable" class="table">
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
@endsection

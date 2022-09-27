@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                [
                    'entity' => 'attribute.submenu.attributes_group',
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
                        <th>Количество атрибутов</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($groups as $group)
                        <tr>
                            <td>{{$group->title ?? '-'}}</td>
                            <td>{{$group->attributes->count()}}</td>
                            <td>@include('admin.macros.table-buttons', ['entity' => $group])</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection

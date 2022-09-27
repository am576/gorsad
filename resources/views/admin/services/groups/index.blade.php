@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                [
                    'entity' => 'service.submenu.service_group',
                    'mode' => 'index',
                    'with_buttons' => true
                ]
            )
@endsection
@section('content')
        <div class="panel panel-bordered">
            <div class="panel-body">
                <table class="table">
                <thead>
                    <tr>
                        <th class="p-3">Название</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td class="p-3">{{$group->name}}</td>
                        <td class="p-3 text-right">
                            <table-buttons :table="'service_groups'" :id="{{$group->id}}"></table-buttons>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>

@endsection

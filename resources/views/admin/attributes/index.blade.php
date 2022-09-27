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
    <div class="panel panel-bordered">
        <div class="panel-body">
            <div class="table-responsive">
                <table id="dataTable" class="table">
                    <thead>
                    <tr>
                        <th>Категория</th>
                        <th>Название</th>
                        <th>Группа</th>
                        <th>Значения</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($attributes as $attribute)
                        <tr>
                            <td>{{$attribute->category->title ?? '-'}}</td>
                            <td>{{$attribute->name}}</td>
                            <td>{{$attribute->group->title ?? '-'}}</td>
                            <td>
                                @if($attribute->type === 'text' || $attribute->type === 'list')
                                @foreach($attribute->valuesLabels() as $label)
                                    <div class="h-100 badge badge-primary" style="font-size: 100%;">{{$label}}</div>
                                @endforeach
                                @elseif($attribute->type === 'range')
                                    @php($range = $attribute->valuesLabels())
                                    @if(count($range))
                                    {{$range[0]}} &mdash; {{$range[1]}}
                                    @endif
                                @elseif($attribute->type === 'bool')
                                    Да / Нет
                                @endif
                            </td>
                            <td>@include('admin.macros.table-buttons', ['entity' => $attribute])</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection

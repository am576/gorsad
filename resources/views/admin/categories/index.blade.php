@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header',
                [
                    'entity' => 'category',
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
                        <th>Родит. категория</th>
                        <th>Картинка</th>
                        <th>Количество товаров</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->title}}</td>
                            <td>{{$category->parentCategory()->title ?? '-'}}</td>
                            <td>
                                <?php $img =  $category->images()->first()->icon ?? '' ?>
                                <img width="100" src="{{URL::asset('storage/images/' . $img)}}" alt="">
                            </td>
                            <td>{{$category->products()->count()}}</td>
                            <td>
                                </td>
                            <td>@include('admin.macros.table-buttons', ['entity' => $category])</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>
@endsection

@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'attribute.submenu.attributes_group', 'mode' => 'edit'])
@endsection
@section('content')
    <div class="admin-form row">
        <div class="col-4">
            <form action="/admin/attributes_groups/{{$group->id}}" method="post">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label>Название</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{$group->title}}">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-lg btn-rounded btn-blue" value="Сохранить">
                </div>
            </form>
        </div>
    </div>
@endsection

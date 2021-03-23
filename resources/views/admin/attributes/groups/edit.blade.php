@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'attribute.submenu.0', 'mode' => 'edit'])
@endsection
@section('content')
    <form action="/admin/attributes_groups/{{$group->id}}" method="post">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label>Название</label>
            <input type="text" id="title" name="title" value="{{$group->title}}">
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
            <input type="submit" value="Сохранить">
        </div>
    </form>
@endsection

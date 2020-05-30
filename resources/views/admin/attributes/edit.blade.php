@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'attribute', 'mode' => 'edit'])
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div><br />
@endif
<form method="POST" action="/admin/attributes/{{$attribute->id}}">
@csrf
@method('PUT')
    <div class="form-group">
        <label for="category_id">Категория</label>
        @include('admin.macros.category-selector', ['selected_category' => $attribute->category_id, 'children_only' => true])
    </div>
    <div class="form-group">
        <label for="title">Название</label>
        <input type="text" id="name" name="name" value="{{$attribute->name}}">
    </div>
    <div class="form-group">
        <label for="value">Значение</label>
        <input type="text" id="value" name="value" value="{{$attribute->value}}">
    </div>
    <div class="form-group">
        <input type="submit" value="Сохранить">
    </div>
</form>
@endsection

@extends('admin.master')
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
<form method="POST" action="/admin/categories">
@csrf
    <div class="form-group">
        <label for="title">Название</label>
        <input type="text" id="title" name="title">
    </div>
    <div class="form-group">
        <label for="parent_id">Родительская категория</label>
        @include('admin.macros.category-selector', ['input_name' => 'parent_id'])
    </div>
    <div class="form-group">
        <label for="description">Описание</label>
        <input type="text" id="description" name="description">
    </div>
    <div class="form-group">
        <input type="submit" value="Создать">
    </div>
</form>
@endsection

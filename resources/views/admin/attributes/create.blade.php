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
<form method="POST" action="/admin/attributes">
@csrf
    <div class="form-group">
        <label for="category_id">Категория</label>
        @include('admin.macros.category-selector', ['children_only' => true])
    </div>
    <div class="form-group">
        <label for="name">Название</label>
        <input type="text" id="name" name="name">
    </div>
    <div class="form-group">
        <label for="values">Значение</label>
        <input type="text" id="values" name="values">
    </div>
    <div class="form-group">
        <input type="submit" value="Создать">
    </div>
</form>
@endsection

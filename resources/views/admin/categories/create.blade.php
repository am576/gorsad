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
<form method="POST" action="/admin/products">
@csrf
    <div class="form-group">
        <label for="title">Название</label>
        <input type="text" id="title" name="title">
    </div>
    <div class="form-group">
        <label for="code">Код товара</label>
        <input type="text" id="code" name="code">
    </div>
    <div class="form-group">
        <label for="description">Описание</label>
        <input type="text" id="description" name="description">
    </div>
    <div class="form-group">
        <label for="category">Категория</label>
        <input type="text" id="category_id" name="category_id">
    </div>
    <div class="form-group">
        <label for="price">Цена</label>
        <input type="text" id="price" name="price">
    </div>
    <div class="form-group">
        <label for="discount">Скидка</label>
        <input type="text" id="discount" name="discount">
    </div>
    <div class="form-group">
        <label for="quantity">Количество</label>
        <input type="text" id="quantity" name="quantity">
    </div>
    <div class="form-group">
        <label for="status">Статус</label>
        <input type="text" id="status" name="status">
    </div>
    <div class="form-group">
        <input type="submit" value="Создать">
    </div>
</form>
@endsection
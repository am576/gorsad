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
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="title">Название</label>
                <input type="text" id="title" name="title" value="{{old('title')}}" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="code">Код товара</label>
                <input type="text" id="code" name="code" value="{{old('code')}}" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <input type="text" id="description" name="description" value="{{old('description')}}" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="category_id">Категория</label>
                <category-selector :children_only="true"></category-selector>
                @include('admin.macros.category-selector', ['children_only' => true])
            </div>
            <div class="form-group">
                <label for="price">Цена</label>
                <input type="text" id="price" name="price" value="{{old('price')}}">
            </div>
            <div class="form-group">
                <label for="discount">Скидка</label>
                <input type="text" id="discount" name="discount" value="{{old('discount')}}">
            </div>
            <div class="form-group">
                <label for="quantity">Количество</label>
                <input type="text" id="quantity" name="quantity" value="{{old('discount')}}">
            </div>
            <div class="form-group">
                <label for="status">Статус</label>
                @include('admin.macros.product-status-selector')
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-row">
                <div class="form-group">
                    <label for="attribute_name">Название</label>
                    <input class="form-control" type="text" name="attribute_name" id="attribute_name">
                </div>
                <div class="form-group">
                    <label for="attribute_value">Значение</label>
                    <input class="form-control" type="text" name="attribute_value" id="attribute_value">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="submit" value="Создать">
    </div>
</form>
@endsection

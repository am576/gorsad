@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'product', 'mode' => 'edit'])
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

    <form method="POST" action="/admin/products/{{$product->id}}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" id="title" name="title" value="{{$product->title}}">
                </div>
                <div class="form-group">
                    <label for="code">Код товара</label>
                    <input type="text" id="code" name="code" value="{{$product->code}}">
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <input type="text" id="description" name="description" value="{{$product->description}}">
                </div>
                <div class="form-group">
                    <label for="category_id">Категория</label>
                    <category-selector :children_only="true" :category_id="{{$product->category_id}}"></category-selector>
                </div>
                <div class="form-group">
                    <label for="price">Цена</label>
                    <input type="text" id="price" name="price" value="{{$product->price}}">
                </div>
                <div class="form-group">
                    <label for="discount">Скидка</label>
                    <input type="text" id="discount" name="discount" value="{{$product->discount}}">
                </div>
                <div class="form-group">
                    <label for="quantity">Количество</label>
                    <input type="text" id="quantity" name="quantity" value="{{$product->quantity}}">
                </div>
                <div class="form-group">
                    <label for="status">Статус</label>
                    @include('admin.macros.product-status-selector', ['value' => $product->status])
                </div>
                <div class="form-group">
                    <input type="submit" value="Сохранить">
                </div>
            </div>
            <div class="col-md-4">
                <h3>Атрибуты</h3>
                <attribute-selector-edit :prop_attributes="{{$product->attributes()}}"></attribute-selector-edit>
            </div>
        </div>
    </form>
@endsection

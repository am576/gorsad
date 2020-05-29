@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'category', 'mode' => 'edit'])
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
<form method="POST" action="/admin/categories/{{$category->id}}">
@csrf
@method('PUT')
    <div class="form-group">
        <label for="title">Название</label>
        <input type="text" id="title" name="title" value="{{$category->title}}">
    </div>
    <div class="form-group">
        <label for="parent_id">Родительская категория</label>
        @php $categories = $category->getCategoriesExceptSelf()@endphp
        <select name="parent_id" id="parent_id">
            <option value="0">-</option>
            @foreach($categories as $category_option)
                <option value="{{$category_option->id}}" @if($category_option->id==$category->id) selected="selected"@endif>{{$category_option->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="description">Описание</label>
        <input type="text" id="description" name="description" value="{{$category->description}}">
    </div>
    <div class="form-group">
        <input type="submit" value="Сохранить">
    </div>
</form>
@endsection

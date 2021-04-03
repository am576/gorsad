@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'filter', 'mode' => 'index'])
@endsection
@section('content')
    <form action="/admin/filter" method="post">
        @csrf
        @for($i = 1; $i <= 3; $i++)
        <div class="form-group">
            <label>Атрибут {{$i}}</label>
            <select class="form-control" name="attributes[]" id="attribute_{{$i}}">
                <option value="0">...</option>
                @foreach($attributes as $attribute)
                    <option value="{{$attribute->id}}"
                        @if($attribute->id ==$filter_attributes[$i-1]->id )
                            selected
                        @endif>
                        {{$attribute->name}}</option>
                @endforeach
            </select>
        </div>

        @endfor
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="btn btn-primary white--text">Сохранить</button>
    </form>
@endsection

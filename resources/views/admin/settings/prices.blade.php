@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'price', 'mode' => 'index'])
@endsection
@section('content')
    <form action="/admin/prices" method="post">
        @csrf
        <div class="row">
            <div class="form-group col-4">
                <label>Тип</label>
                <select class="form-control" name="type">
                    <option value="fixed">Фиксированный</option>
                    <option value="percent">Процент</option>
                </select>
            </div>
            <div class="form-group col-4">
                <label>Количество</label>
                <input type="number" name="amount" class="form-control">
            </div>
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
        <button type="submit" class="btn btn-primary white--text">Сохранить</button>
    </form>
@endsection

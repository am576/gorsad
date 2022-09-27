@extends('admin.master')
@section('page_header')
    @include('admin.partials.page_header', ['entity' => 'attribute.submenu.attributes_group', 'mode' => 'create'])
@endsection
@section('content')
    <div class="admin-form">
        <form action="/admin/attributes_groups" method="post">
            @csrf
            <div class="form-group">
                <label>Название</label>
                <input type="text" id="title" name="title">
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
                <input type="submit" value="Создать">
            </div>
        </form>
    </div>
@endsection

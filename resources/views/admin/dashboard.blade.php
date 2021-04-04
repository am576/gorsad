@extends('admin.master')
@section('content')
    <div class="container dashboard">
        <div class="row">
            @foreach(config('admin.menu') as $menu_item)
                <div style="width: 20%; padding: 5px 20px; margin-bottom: 20px;">
                    <a href="/admin/{{$menu_item['route']}}" class="admin-link">
                        <span class="mdi mdi-{{$menu_item['icon']}}"></span>
                        {{$menu_item['title']}}
                    </a>
                </div>
            @endforeach

        </div>
    </div>

@endsection

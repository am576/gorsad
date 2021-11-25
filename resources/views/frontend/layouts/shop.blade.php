@extends('frontend.layouts.master')
@section('title', 'Gorsad')
@section('body')
    <div id="app" data-app class="shop">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
@endsection

@extends('frontend.layouts.app')
@section('title', 'Gorsad - Дизайн')
@section('content')
    @push('styles')
        <link href="{{ asset('css/design.css') }}" rel="stylesheet">
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/flipbook-vue/dist/vue2/flipbook.min.js" defer></script>
    @endpush
    @yield('page')
@endsection

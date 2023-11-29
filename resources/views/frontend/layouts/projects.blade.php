@extends('frontend.layouts.static_page')
@section('title', 'Горсад - Наши работы')
@push('styles')
    <link href="{{ asset('css/projects.css') }}" rel="stylesheet">
@endpush
@section('menu')
    <a href="{{route('project_type_page','industrial')}}">Промышленные объекты</a>
    <a href="{{route('project_type_page','school')}}">Школы</a>
    <a href="{{route('project_type_page','private')}}">Частные проекты</a>
    <a href="{{route('project_type_page','compensation')}}">Компенсационное озеленение</a>
@endsection
@section('category-link')
    /
    <a href="{{route('projects')}}">Наши работы</a>
    @hasSection('current-page-link')
        /
    @endif
@endsection
@section('landing-form')
    <div id="projects-landing-form" class="body-bg">
        <div class="projects-landing-form-inner container-pd">
            <h4 class="heading">Хотите обсудить проект или задать вопросы?</h4>
            <form action="">
                <div><input type="text" placeholder="Имя"></div>
                <div><input type="text" placeholder="Телефон"></div>
                <div><input type="text" placeholder="E-mail"></div>
                <button class="btn-green no-border-radius">Обсудить проект</button>
            </form>
        </div>
    </div>
@endsection

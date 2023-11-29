@extends('frontend.layouts.projects')
@section('title', 'Горсад - Наши работы | ' . $type_name)
@section('current-page-link')
    <a href="{{route('project_type_page',$type)}}">{{$type_name}}</a>
@endsection
@section('content')

    <div id="project-type-page" class="body-bg">
        <div class="container-pd">
            <h4 id="page-title" class="heading">{{$type_name}}</h4>
        </div>
        @if(count($projects))
            <img class="project-type-bg" src="/storage/images/{{$projects[0]->images[0]->large}}" alt="">
            <div class="container-pd">
                <a href="{{route('project_page', $projects[0]->id)}}">
                    <div class="project-details">
                        <div class="project-name">{{$projects[0]->name}}</div>
                        <div class="project-description">{{$projects[0]->description}}</div>
                    </div>
                </a>
                <div id="projects-list">
                    @foreach(array_slice($projects->toArray(), 1) as $project)
                        <div class="project-card" onclick="window.location.href='{{route('project_page',$project['id'])}}'">
                            <img src="/storage/images/{{$project['images'][0]['large']}}" alt="">
                            <div class="project-details">
                                <div class="project-name">
                                    <span>{{$project['name']}}</span>
                                    <img src="/storage/images/public/icons/arrow_right_up.png" alt="">
                                </div>
                                <div class="project-description">{{$project['description']}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="container-pd pb-5">Пока нет проектов в данной категории</div>
        @endif
    </div>
@endsection

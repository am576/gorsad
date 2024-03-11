@extends('frontend.layouts.projects')
@section('title', 'Горсад - Наши работы | ' . $type_name)
@section('current-page-link')
    <a href="{{route('project_type_page',$project->type)}}">{{$type_name}}</a>
    /
    <a href="{{route('project_page',$project->id)}}">{{$project->name}}</a>
@endsection
@section('content')
    <div id="project-page" class="body-bg">
        <div class="container-pd">
            <h4 id="page-title" class="heading">{{$project->name}}</h4>
        </div>
        <img class="project-bg" src="/storage/images/{{$project->images[0]->large}}" alt="">
        <div class="container-pd">
            <div id="project-details">
                {{-- <div class="project-info">
                    <div class="project-date">
                        {{date('Y', strtotime($project->date))}}
                    </div>
                    <div class="project-specs">
                        <div>{{$project->trees_count}} деревьев</div>
                        <div>{{$project->area}} м<sup>2</sup></div>
                        <div>{{$project->price}} &#8381;</div>
                    </div>
                </div> --}}
                <div class="project-description">
                    {{$project->description}}
                </div>
            </div>
            <project-images :project="{{$project}}"></project-images>
            <div id="project-plants">
                <h4 class="heading">Растения из этого проекта</h4>
                <div id="project-plants-list">
                    @foreach($project->plants as $plant)
                        <div class="project-plant-card">
                            <div class="plant-img">
                                <img src="/storage/images/{{$plant->images[0]->medium}}" alt="">
                            </div>
                            <div class="plant-title">{{$plant->text}}</div>
                            <button class="btn-green" onclick="window.location.assign('/shop/products/' + {{$plant->id}})">Описание</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

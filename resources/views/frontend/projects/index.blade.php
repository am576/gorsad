@extends('frontend.layouts.projects')
@section('content')
    <div id="projects_index_page" class="container-pd">
        <h4 class="heading">Наши Работы</h4>
        <div id="projects">
            @foreach($projects as $type_name => $project_type)
                @if($type_name)
                    <div class="project-type-row">
                        <div class="project-type-heading">
                            <h4 class="heading project-type-name">{{config('projects.types.'.$type_name.'.name')}}</h4>
                            <p class="project-type-description">{{config('projects.types.'.$type_name.'.description')}}</p>
                        </div>
                        <div class="project-type-links">
                            @foreach($project_type->slice(0,4) as $project)
                                <div class="project-type-link" onclick="window.location.href='/projects/'+{{$project->id}}">
                                    <img src="/storage/images/{{$project->images[0]->medium}}" alt="">
                                    <div class="project-name"><div class="project-name-wr">{{$project->name}}</div></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

@extends('frontend.layouts.app')
@section('title', 'Gorsad - Проекты')
@section('content')
<div class="container-fluid project-page">
    <div class="row justify-content-center">
        <div class="col-md-12 p-0">
           <div class="project-img-main" style="background-image: url({{'/storage/images/'.$project->images[0]['large']}} );">
               <p class="project-name">{{$project->name}}</p>
           </div>
            <div class="row justify-content-center flex-column align-items-center">
                <div class="project-details text-left">
                    <p class="project-description">
                        {!!$project->description!!}
                    </p>
                    <div class="row project-params flex-column justify-content-center align-items-center">
                        <div class="col-12 col-sm-10 col-md-10 col-lg-6">
                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5">Место</div>
                            <div class="col-5 col-sm-5 col-md-5">{{$project->place}}</div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5">Площадь</div>
                            <div class="col-5 col-sm-5 col-md-5">{{$project->area}} м<sup>2</sup></div>
                        </div>
                        @if($project->client)
                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5">Заказчик</div>
                            <div class="col-5 col-sm-5 col-md-5">{{$project->client}}</div>
                        </div>
                        @endif
                        <div class="row pt-2 pb-2">
                            <div class="col-5 col-sm-5 col-md-5">Растения</div>
                            <div class="col-5 col-sm-5 col-md-5">
                                @foreach($project->plants() as $plant)
                                    <a class="plant-tag mt-2" style="line-height: 40px;" href="{{'/products/'.$plant->id}}" target="_blank">{{$plant->text}}</a>
                                @endforeach
                            </div>
                        </div>
                        @if($project->doneby)
                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5">Благоустройство</div>
                            <div class="col-5 col-sm-5 col-md-5">{{$project->doneby}}</div>
                        </div>
                        @endif
                    </div>
                    </div>
                </div>
                <div class="images-wrapper row w-100 justify-content-center" style="background-color: #efefef;">
                    <project-images :project="{{$project}}"></project-images>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

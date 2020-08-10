@extends('frontend.layouts.app')
@section('title', 'Интернет-магазин канцтоваров "Карандаш"')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 pr-5 pl-5">
            <home-slider></home-slider>
            <div class="pt-3 border-bottom">
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-md-3">
                            <a style="display: block !important; margin-top: 1rem; border: 1px solid" href="categories/{{$category->url_title}}">
                                <img  width="100%" src="/storage/images/{{$category->image()->medium}}" alt="{{$category->image()->label}}">
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

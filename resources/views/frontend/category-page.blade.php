@extends('frontend.layouts.app')
@section('title', $category->title)
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 pr-5 pl-5">
            <div class="pt-3 border-bottom">
                @if(isset($child_categories))
                    <div class="row">
                        @foreach($child_categories as $category)
                            <div class="col-md-3">
                                <a style="display: block !important; margin-top: 1rem; border: 1px solid" href="{{$category->url_title}}">
                                    <img  width="100%" src="/storage/images/{{$category->image()->medium}}" alt="{{$category->image()->label}}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <products-list :products="{{$products}}"></products-list>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@extends('frontend.layouts.guide')
@section('title', 'Gorsad - Руководство по обрезке')
@section('body')
<div class="container-fluid">
    <guide-flipbook :guide_name="'pruning'"></guide-flipbook>
</div>
@endsection

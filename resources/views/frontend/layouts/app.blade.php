@extends('frontend.layouts.master')
@section('title', 'Gorsad')
@section('body')
    <?php
    use App\Utils\User as UserUtils;
    $user = UserUtils::getAuthUser();
    ?>
    <div id="app" data-app class="frontend">
        <site-navigation :user="{{json_encode($user)}}"></site-navigation>
        <main>
            @yield('content')
            @include('frontend.layouts.footer')
        </main>
    </div>
@endsection

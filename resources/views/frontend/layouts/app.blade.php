@extends('frontend.layouts.master')
@section('title', 'Gorsad')
@section('body')
    <div id="app" data-app class="frontend">
        <?php
        use Illuminate\Support\Facades\Auth;
        use App\User;
        $user = $auth_user = Auth::user();
        if(isset($user))
        {
            $user = User::where('id',auth()->user()->id)->with(['user_notifications', 'companies'])->first();
            $user->favorites = $user->favorites();
        }
        ?>
        <site-navigation @if(isset($auth_user)):auth_user="{{$auth_user}}" :user="{{json_encode($user)}}"@endif></site-navigation>
        <main>
            @yield('content')
            @include('frontend.layouts.footer')
        </main>
    </div>
@endsection

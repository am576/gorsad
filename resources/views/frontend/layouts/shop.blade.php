@extends('frontend.layouts.master')
@section('title', 'Gorsad')
@section('body')
    <div id="app" data-app class="shop">
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
        <main class="py-4">
            @yield('content')
        </main>
    </div>
@endsection

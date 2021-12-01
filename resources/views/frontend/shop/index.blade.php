@extends('frontend.layouts.shop')
@section('title', 'Gorsad')
@section('content')
    <?php
    use Illuminate\Support\Facades\Auth;
    use App\User;
    $user = $auth_user = Auth::user();
    if(isset($user))
    {
        $user = User::where('id',auth()->user()->id)->first();
        $user->favorites = $user->favorites();
    }
    ?>
    <shop-page :products_all="{{$products}}" :attributes="{{$attributes}}" @if(isset($auth_user)):auth_user="{{$auth_user}}" :user="{{json_encode($user)}}"@endif></shop-page>
@endsection

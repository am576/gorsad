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
        if(!isset($filtered_name)) {
            $filtered_name = '';
        }
        if(!isset($filter_options)) {
            $filter_options = '[]';
        }
    }
    ?>
    <shop-page :products_all="{{$products}}" :attributes="{{$attributes}}" :filtered_name="{{"'".$filtered_name ."'" }}" :filter_options="{{$filter_options}}" @if(isset($auth_user)):auth_user="{{$auth_user}}" :user="{{json_encode($user)}}"@endif></shop-page>
@endsection

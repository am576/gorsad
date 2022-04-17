@extends('frontend.layouts.shop')
@section('title', $product->title)
@section('content')
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
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-1 filler"></div>
        <div class="col-md-10 col-sm-12">
            <shop-navigation @if(isset($auth_user)):auth_user="{{$auth_user}}" :user="{{json_encode($user)}}"@endif>
                <template slot="back_btn">
                    <a href="/shop" class="back_btn d-flex align-items-center">
                        <span class="mdi mdi-chevron-left mdi-24px"></span>
                        <span>Назад к обзору</span>
                    </a>
                </template>
            </shop-navigation>
            <product-page :product="{{$product}}"></product-page>
        </div>
        <div class="col-1"></div>
    </div>
    <div class="container-fluid mt-2" style="padding: 50px 0 !important; background: #434242">
{{--        <product-images :product="{{$product}}"></product-images>--}}
    </div>
</div>
@endsection

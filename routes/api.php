<?php

use App\Order;
use App\UserNotification;
use App\UserQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('getAllCategories','ApiController@getAllCategories');
Route::get('getChildCategories','ApiController@getChildCategories');
Route::get('getCategoriesExceptSelf','ApiController@getCategoriesExceptSelf');
Route::get('getProductCategory','ApiController@getProductCategory');
Route::get('getAttributesForCategory','ApiController@getAttributesForCategory');
Route::get('getAttributeValues', 'ApiController@getAttributeValues');
Route::get('getAttributesGroups', 'ApiController@getAttributesGroups');
Route::get('getImages', 'ApiController@getImages');
Route::get('filterProducts', 'ApiController@filterProducts');
Route::get('getProducts', 'ApiController@getProducts');
Route::get('getTable', 'ApiController@getTable');
Route::get('getAttributesTypes', 'ApiController@getAttributesTypes');
Route::get('getIconsets', 'ApiController@getIconsets');
Route::get('getAttributeIcons', 'ApiController@getAttributeIcons');
Route::get('getCategoryParams', 'ApiController@getCategoryParams');
Route::get('searchProduct', 'ApiController@searchProducts');
Route::get('getServiceGroups', 'ApiController@getServiceGroups');

Route::get('paginateProjects', 'ApiController@paginateProjects');
Route::get('paginateServices', 'ApiController@paginateservices');
Route::get('getGuideImageNames', 'ApiController@getGuideImageNames');

Route::post('approveQuery', function (Request $request) {
    $order_data = $request->all();

    $order = new Order([
        'user_id' => $order_data['user_id'],
        'query_id' => $order_data['query_id'],
        'status' => 'new',
        'order_file_link' => '/some/location/file.pdf'
    ]);

    if($order->save())
    {
        $query = UserQuery::where('id', $order->query_id)->first();
        $query->status = 'approved';
        $query->save();

        return response('Запрос одобрен, id заказа = ' . $order->id, 200);
    }

    return response('Error creating order', 300);
});

Route::get('isFeatureEnabled/{name}', 'ApiController@isFeatureEnabled');

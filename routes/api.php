<?php

use Illuminate\Http\Request;
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

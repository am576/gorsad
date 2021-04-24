<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/','HomeController@index');
Route::get('/categories/{url_title}', ['uses' => 'HomeController@categoryPage']);
Route::get('/products/{product_id}', ['uses' => 'HomeController@productPage']);
//Route::get('/shop', 'HomeController@showShopPage')->name('shop');
Route::get('/shop', 'HomeController@showShopPage')->name('shop');
Route::post('/search', 'HomeController@ApplyFilter');
Route::get('/getfavorites','UserController@getUserFavorites');
Route::post('/favorite', 'UserController@toggleProductFavorite');

Route::get('/cart', 'HomeController@showCart');
Route::get('/cart/add/', 'CartController@addProduct');
Route::get('/cart/changequantity', 'CartController@changeProductQuantity');
Route::get('/cart/totalprice', 'CartController@getTotalPrice');
Route::get('/cart/removeproduct', 'CartController@removeProduct');
Route::get('/cart/getCart', 'ApiController@getCart');

Route::get('/cart/checkout', 'HomeController@showCheckoutPage');
Route::post('/cart/checkout', 'CartController@createQuery');
Route::post('/cart/clear','CartController@clearCart');

Route::get('/profile/{tab?}', 'UserController@showProfilePage');
Route::post('/profile/notification', 'UserController@readNotification');
Route::get('/profile/notification/readall', 'UserController@readAllNotifications');
Route::get('/querypdf','UserController@getQueryPdf');
Route::get('/orderpdf','UserController@getOrderPdf');
Route::get('/logascompany','UserController@setCompanyActive');
Route::get('/logasuser','UserController@setCompaniesNotActive');


/*Admin routes*/
Route::get('/admin/orders', 'OrderController@index');
Route::get('/admin/orders/{id}', 'OrderController@show');
Route::get('/admin/queries/{id}', 'OrderController@showUserQuery');
Route::post('/admin/queries/{id}/approve', 'OrderController@createOrderFromQuery');
Route::get('/admin/clients', 'ClientController@index');


Route::prefix('admin')->group(function(){

    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/','Auth\AdminController@index')->name('admin.dashboard');

    Route::get('/filter', 'SettingsController@showFilerSettingsPage');
    Route::post('/filter', 'SettingsController@saveFilterSettings');

    Route::get('/prices', function () {
        return view('admin.settings.prices');
    });
    Route::post('/prices','SettingsController@SaveAndApplyExtraPrice');

    Route::resources([
        'products'    => 'ProductController',
        'categories'  => 'CategoryController',
        'attributes'  => 'AttributeController',
        'attributes_groups'  => 'AttributesGroupController',
        'icon_sets' => 'IconSetController'
    ]);

    Route::post('/images-upload', 'ImagesController@upload');
});


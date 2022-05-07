<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/','HomeController@index');


Route::post('/search', 'HomeController@ApplyFilter');
Route::get('/getfavorites','UserController@getUserFavorites');
Route::post('/favorite', 'UserController@toggleProductFavorite');
Route::post('/postreview','UserController@postReview');
Route::post('/donotreview','UserController@doNotReview');

Route::prefix('shop')->group(function() {
    Route::get('/', 'ShopController@showShopPage')->name('shop');
    Route::get('/products/{product_id}',  'ShopController@productPage');
    Route::post('/compare/add','ShopController@addProductsToCompare');
    Route::post('/compare/remove','ShopController@removeFromCompare');
    Route::get('comparison', 'ShopController@getProductsForComparison');
    Route::post('filter', 'ShopController@applyFilter')->name('filter');
    Route::get('load', 'ShopController@loadProducts');
});

Route::get('/cart', 'HomeController@showCart');
Route::get('/cart/add/', 'CartController@addProduct');
Route::get('/cart/changequantity', 'CartController@changeProductQuantity');
Route::get('/cart/totalprice', 'CartController@getTotalPrice');
Route::get('/cart/removeproduct', 'CartController@removeProduct');
Route::get('/cart/removeproductvariant', 'CartController@removeProductVariant');
Route::get('/cart/getCart', 'ApiController@getCart');
Route::post('/cart/usebonuses', 'CartController@useBonuses');
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

Route::get('/projects', 'HomeController@showProjectsPage')->name('projects.index');
Route::get('/projects/all', 'HomeController@showProjects')->name('projects.all');
Route::get('/projects/{id}', 'HomeController@showProjectPage');

Route::get('/knowhow','HomeController@showKnowhowPage');
Route::get('/styles','HomeController@showStylesPage');

Route::get('/services', 'HomeController@showServicesPage');
Route::get('/services/{id}', 'HomeController@showServicePage');
Route::post('/services/{id}/order', 'ShopController@createOrderService');

/*Admin routes*/
Route::get('/admin/orders', 'OrderController@index')->name('orders.index');
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

    Route::get('/querypdf','OrderController@getQueryPdf');
    Route::get('/orderpdf','OrderController@getOrderPdf');

    route::get('/service_order/{id}','OrderController@setServiceOrderStatus');

    Route::resources([
        'products'    => 'ProductController',
        'categories'  => 'CategoryController',
        'attributes'  => 'AttributeController',
        'attributes_groups'  => 'AttributesGroupController',
        'icon_sets' => 'IconSetController',
        'projects' => 'ProjectController',
        'services' => 'ServiceController',
        'service_groups' => 'ServiceGroupController',
    ]);

    Route::post('/images-upload', 'ImagesController@upload');
});

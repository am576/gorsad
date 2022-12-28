<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Auth::routes();

Route::get('getToken', function() {
    dd(csrf_token());
});

Route::get('/','HomeController@index');

Route::post('/search', 'HomeController@ApplyFilter');
/*
 * Route::get('/getfavorites','UserController@getUserFavorites');
Route::post('/favorite', 'UserController@toggleProductFavorite');
Route::post('/postreview','UserController@postReview');
Route::post('/donotreview','UserController@doNotReview');
*/

Route::prefix('shop')->group(function() {
    Route::get('/', 'ShopController@showShopPage')->name('shop');
    Route::get('/products/{product_id}',  'ShopController@productPage');
    Route::post('/compare/add','ShopController@addProductsToCompare');
    Route::post('/compare/remove','ShopController@removeFromCompare');
    Route::get('comparison', 'ShopController@getProductsForComparison');
    Route::post('filter', 'ShopController@applyFilter')->name('filter');
    Route::get('load', 'ShopController@loadProducts');
});

/*
 * Route::get('/cart', 'HomeController@showCart');
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
*/

/*
 * Route::get('/user/orders/{id}', 'UserController@getOrder')->middleware(['owns_order']);
Route::post('/user/orders/{id}/cancel', 'UserController@cancelOrder')->middleware(['owns_order']);
*/

/*
 * Route::get('/profile/{tab?}', 'UserController@showProfilePage');
Route::post('/profile/notification', 'UserController@readNotification');
Route::get('/profile/notification/readall', 'UserController@readAllNotifications');
Route::get('/querypdf','UserController@getQueryPdf');
Route::get('/orderpdf','UserController@getOrderPdf');
Route::get('/logascompany','UserController@setCompanyActive');
Route::get('/logasuser','UserController@setCompaniesNotActive');
*/

Route::get('/projects', 'HomeController@showProjectsPage')->name('projects.index');
Route::get('/projects/all', 'HomeController@showProjects')->name('projects.all');
Route::get('/projects/{id}', 'HomeController@showProjectPage');

//**** STATIC PAGES *****/
Route::prefix('knowhow')->group(function() {
    Route::get('/',function() {
        return view('frontend.knowhow.index');
    });
    Route::get('/planning',function() {
        return view('frontend.knowhow.planning');
    })->name('planning');
    Route::get('/ordering',function() {
        return view('frontend.knowhow.ordering');
    })->name('trees_ordering');
    Route::get('/shape_trees',function() {
        return view('frontend.knowhow.shape_trees
    ');
    })->name('shape_trees');
    Route::get('/trees_transport',function() {
        return view('frontend.knowhow.trees_transport
    ');
    })->name('trees_transport');

});
Route::get('/guide/{guide_name}', 'HomeController@ShowGuidePage')->name('guide');

Route::get('/design',function() {
    return view('frontend.design.index');
});
Route::get('/design/styles',function() {
    return view('frontend.design.design_styles');
})->name('design_styles');
Route::get('/design/outdoor',function() {
    return view('frontend.design.outdoor_design');
})->name('outdoor_design');
Route::get('/design/ecology',function() {
    return view('frontend.design.ecology');
})->name('ecology');
Route::get('/design/roofs-and-containers',function() {
    return view('frontend.design.roofs');
})->name('roofs');
Route::get('/design/street-profiles',function() {
    return view('frontend.design.streets');
})->name('street_profiles');
Route::get('/design/street-lighting',function() {
    return view('frontend.design.lighting');
})->name('street_lighting');

Route::get('/services', 'HomeController@showServicesPage');
Route::get('/services/{id}', 'HomeController@showServicePage');
Route::post('/services/{id}/order', 'ShopController@createOrderService');

Route::get('/contacts', function() {
    return view('frontend.contacts');
});

//**** END STATIC PAGES *****/


/*Admin routes*/



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

    Route::get('/orders', 'OrderController@index')->name('orders.index');
    Route::get('/orders/{id}', 'OrderController@show');
    Route::get('/queries/{id}', 'OrderController@showUserQuery');
    Route::post('/queries/{id}/approve', 'OrderController@createOrderFromQuery');
    Route::post('/queries/{id}/cancel', 'OrderController@CancelUserQuery');
    Route::get('/clients', 'ClientController@index');

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

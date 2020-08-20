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

Route::get('/','HomeController@maintenance');
//Route::get('/','HomeController@index');
Route::get('/categories/{url_title}', ['uses' => 'HomeController@categoryPage']);
Route::get('/admin/orders', 'OrderController@index');
Route::get('/admin/orders/{id}', 'OrderController@show');
Route::get('/admin/clients', 'ClientController@index');

/*Admin routes*/
Route::prefix('admin')->group(function(){

    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/','Auth\AdminController@index')->name('admin.dashboard');

    Route::resources([
        'products'    => 'ProductController',
        'categories'  => 'CategoryController',
        'attributes'  => 'AttributeController'
    ]);

    Route::post('/images-upload', 'ImagesController@upload');
});


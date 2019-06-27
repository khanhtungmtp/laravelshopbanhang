<?php

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

Route::get('/', 'HomeController@index');
Route::view('/admin/login', 'admin.pages.login')->name('admin.getLogin');
Route::post('/admin/login', 'UserController@loginAdmin')->name('admin.postLogin');
Route::get('getProductType', 'AjaxController@getProductType');
Route::group(['prefix' => 'admin','middleware' => 'adminMiddleware'], function ()
{
    Route::view('/','admin.pages.index');
    Route::resource('category', 'CategoryController');
    Route::resource('product-type', 'ProductTypeController');
    Route::resource('product', 'ProductController');
});
// Đăng nhập facebook
Route::get('callback/{social}','UserController@handleProviderCallback');
Route::get('login/{social}','UserController@redirectToProvider')->name('login.social');
Route::get('logout','UserController@logout');
Route::post('register','UserController@register')->name('register');
Route::post('login','UserController@loginClient')->name('login.client');
// Cart
Route::resource('cart','CartController');
Route::get('add-cart/{id}','CartController@addCart')->name('addCart');
// checkout
Route::get('checkout','CartController@checkout')->name('cart.checkout');
Route::resource('customer','CustomerController');

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

Route::get('/', function () {
    return view('client.pages.index');
});

Route::get('getProductType', 'AjaxController@getProductType');
Route::group(['prefix' => 'admin'], function ()
{
    Route::resource('category', 'CategoryController');
    Route::resource('product-type', 'ProductTypeController');
    Route::resource('product', 'ProductController');
});

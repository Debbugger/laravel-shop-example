<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::match(['get','post'],'products','ProductsController@index')->name('productSearch');
    Route::get('catalog','ProductsController@catalog')->name('catalog');
    Route::get('{slug}','ProductsController@indexCategory')->name('productCategory');
    Route::get('{category}/{slug}','ProductsController@show')->name('product');
});

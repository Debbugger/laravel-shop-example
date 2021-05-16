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

Route::group(['middleware' => 'auth','prefix' => LaravelLocalization::setLocale().'/cabinet'], function () {
    Route::match(['get','post'],'/', 'UserController@home')->name('userHome');
    Route::match(['get','post'],'favorites', 'UserController@favorites')->name('userFavorites');
    Route::match(['get','post'],'profile', 'UserController@data')->name('userData');
    Route::match(['get','post'],'security', 'UserController@pass')->name('userPass');
});


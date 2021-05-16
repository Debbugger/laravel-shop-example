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
    Route::match(['get', 'post'], 'login', 'AuthController@login')->name('login')->middleware('guest');
    Route::match(['get', 'post'], 'register', 'AuthController@register')->name('register')->middleware('guest');
    Route::post('pre/register', 'AuthController@preRegister')->name('preRegister')->middleware('guest');
    Route::match(['get', 'post'], 'recovery', 'AuthController@recovery')->name('recovery')->middleware('guest');
    Route::get('logout', 'AuthController@logout')->name('logout');
    Route::post('recovery/change','AuthController@changePass')->name('changePass');
});

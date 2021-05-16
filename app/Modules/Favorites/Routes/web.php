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

Route::group(['prefix' => LaravelLocalization::setLocale().'/favorites'], function () {
    Route::post('add','FavoritesController@add' )->name('favoriteAdd');
    Route::post('send','FavoritesController@send' )->name('favoriteSend');
    Route::post('delete','FavoritesController@delete' )->name('favoriteDelete');
    Route::get('/','FavoritesController@index')->name('favorites');
});
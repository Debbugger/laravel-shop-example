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

Route::group(['prefix' => LaravelLocalization::setLocale().'/card'], function () {
    Route::post('add','CardController@add' )->name('cardAdd');
    Route::post('minus','CardController@minus' )->name('cardMinus');
    Route::post('delete','CardController@delete' )->name('cardDelete');
    Route::get('/','CardController@index')->name('card');
    Route::match(['get','post'],'process', 'CardController@process')->name('cardProcess');
    Route::post('process/old','CardController@processOld')->name('cardProcessOld');

});

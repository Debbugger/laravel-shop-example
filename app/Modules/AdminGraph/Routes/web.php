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

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url') . '/gpaph/'], function () {
    Route::post('mounth', 'GraphController@mounth')->name('adminGraphMounth');
});

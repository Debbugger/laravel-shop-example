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

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/orders'], function () {
    Route::get('/','OrdersController@index')->name('adminOrders');
    Route::get('table','OrdersController@table')->name('adminOrdersTable');
    Route::match(['get','post'],'edit','OrdersController@edit')->name('adminOrdersEdit');
    Route::post('create','OrdersController@create')->name('adminOrdersCreate');
    Route::post('delete','OrdersController@delete')->name('adminOrdersDelete');
    Route::post('modal','OrdersController@getModal')->name('adminOrdersModal');
});

Breadcrumbs::register('adminOrders', function ($breadcrumbs) {
    $breadcrumbs->parent('adminHome');
    $breadcrumbs->push('Заказы', route('adminOrders'));
});
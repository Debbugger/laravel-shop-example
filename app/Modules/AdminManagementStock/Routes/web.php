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

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/management/stock'], function () {
    Route::get('/', 'StockController@index')->name('adminManagementStock');
    Route::get('/table', 'StockController@table')->name('adminManagementStockTable');
    Route::post('/create', 'StockController@create')->name('adminManagementStockCreate');
    Route::post('/edit', 'StockController@edit')->name('adminManagementStockEdit');
    Route::post('/delete', 'StockController@delete')->name('adminManagementStockDelete');
    Route::post('/modal', 'StockController@getModal')->name('adminManagementStockModal');
});
Breadcrumbs::register('adminManagementStock', function ($breadcrumbs) {
    $breadcrumbs->parent('adminManagement');
    $breadcrumbs->push('Склад', route('adminManagementStock'));
});

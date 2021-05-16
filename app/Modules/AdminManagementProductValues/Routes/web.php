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


Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/management/product'], function () {
    Route::match(['get','post'],'edit/{id}/value', 'ValuesController@index')->name('adminManagementProductValues');
    Route::get('create/{id}/value', 'ValuesController@indexCreate')->name('adminManagementProductValuesCreate');
    Route::post('value/create', 'ValuesController@create')->name('adminManagementSpecificationValueCreate');
    Route::post('value/edit', 'ValuesController@edit')->name('adminManagementSpecificationValueEdit');
    Route::post('value/modal', 'ValuesController@getModal')->name('adminManagementSpecificationValueModal');

    Route::post('value/delete', 'ValuesController@delete')->name('adminManagementSpecificationValueDelete');
    Route::get('value/delete/{id?}', 'ValuesController@products')->name('adminManagementSpecificationValueProducts');
});
Breadcrumbs::for('adminManagementProductValues', function ($trail, $item = null) {
    $trail->parent('adminManagementProductEdit',$item);
    $trail->push('Характеристики', route('adminManagementProductValues', $item));
});
Breadcrumbs::for('adminManagementProductValuesCreate', function ($trail, $item = null) {
    $trail->parent('adminManagementProductEdit',$item);
    $trail->push('Заполнение характеристик', route('adminManagementProductValuesCreate', $item));
});
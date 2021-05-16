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

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/management/specification'], function () {
    Route::get('/','SpecificationController@index')->name('adminManagementSpecification');
    Route::get('table','SpecificationController@table')->name('adminManagementSpecificationTable');
    Route::match(['get','post'],'edit','SpecificationController@edit')->name('adminManagementSpecificationEdit');
    Route::post('create','SpecificationController@create')->name('adminManagementSpecificationCreate');
    Route::post('delete','SpecificationController@delete')->name('adminManagementSpecificationDelete');
    Route::post('modal','SpecificationController@getModal')->name('adminManagementSpecificationModal');
    Route::post('changeShow','SpecificationController@changeShow')->name('adminManagementSpecificationChangeShow');
});

Breadcrumbs::register('adminManagementSpecification', function ($breadcrumbs) {
    $breadcrumbs->parent('adminManagement');
    $breadcrumbs->push('Характеристики', route('adminManagementSpecification'));
});
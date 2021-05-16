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

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/management/category'], function () {
    Route::get('/', 'CategoryController@index')->name('adminManagementCategory');
    Route::get('table/','CategoryController@table')->name('adminManagementCategoryTable');
    Route::match(['get','post'],'/edit','CategoryController@edit')->name('adminManagementCategoryEdit');
    Route::post('create','CategoryController@create')->name('adminManagementCategoryCreate');
    Route::post('delete','CategoryController@delete')->name('adminManagementCategoryDelete');
    Route::post('image','CategoryController@image')->name('adminManagementCategoryImage');
    Route::post('modal','CategoryController@getModal')->name('adminManagementCategoryModal');
    Route::post('changeShow','CategoryController@changeShow')->name('adminManagementCategoryChangeShow');
    Route::post('modal/seo','CategoryController@getSeoModal')->name('adminManagementCategorySeoModal');
    Route::post('seo','CategoryController@changeSeo')->name('adminManagementCategoryChangeSeo');
});
Breadcrumbs::register('adminManagementCategory', function ($breadcrumbs) {
    $breadcrumbs->parent('adminManagement');
    $breadcrumbs->push('Категории', route('adminManagementCategory'));
});
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
    Route::get('/', 'ProductController@index')->name('adminManagementProducts');
    Route::match(['get','post'],'edit/{id}', 'ProductController@edit')->name('adminManagementProductEdit');
    Route::match(['get','post'],'create', 'ProductController@create')->name('adminManagementProductCreate');
    Route::get('table', 'ProductController@table')->name('adminManagementProductTable');
    Route::post('image', 'ProductController@image')->name('adminManagementProductImage');
    Route::post('category/{id}', 'ProductController@category')->name('adminManagementProductCategory');
    Route::post('images/{id}', 'ProductController@images')->name('adminManagementProductImages');
    Route::post('images/{id}/delete', 'ProductController@imagesDelete')->name('adminManagementProductImagesDelete');
    Route::post('delete', 'ProductController@delete')->name('adminManagementProductDelete');
    Route::post('modal/seo','ProductController@getSeoModal')->name('adminManagementProductSeoModal');
    Route::post('seo','ProductController@changeSeo')->name('adminManagementProductChangeSeo');
});
Breadcrumbs::for('adminManagementProducts', function ($trail, $item = null) {
    $trail->parent('adminManagement');
    $trail->push('Товары', route('adminManagementProducts', $item));
});
Breadcrumbs::for('adminManagementProductCreate', function ($trail, $item = null) {
    $trail->parent('adminManagementProducts');
    $trail->push('Создать', route('adminManagementProductCreate', $item));
});
Breadcrumbs::for('adminManagementProductEdit', function ($trail, $item = null) {
    $trail->parent('adminManagementProducts');
    $trail->push('Редактировать', route('adminManagementProductEdit', $item));
});
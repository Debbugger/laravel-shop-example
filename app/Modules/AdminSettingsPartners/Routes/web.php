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

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/settings/partners'], function () {
    Route::get('/', 'PartnersController@index')->name('adminSettingsPartners');
    Route::get('table/','PartnersController@table')->name('adminSettingsPartnersTable');
    Route::match(['get','post'],'/edit','PartnersController@edit')->name('adminSettingsPartnersEdit');
    Route::post('create','PartnersController@create')->name('adminSettingsPartnersCreate');
    Route::post('delete','PartnersController@delete')->name('adminSettingsPartnersDelete');
    Route::post('image','PartnersController@image')->name('adminSettingsPartnersImage');
    Route::post('modal','PartnersController@getModal')->name('adminSettingsPartnersModal');
    Route::post('changeShow','PartnersController@changeShow')->name('adminSettingsPartnersChangeShow');
});
Breadcrumbs::register('adminSettingsPartners', function ($breadcrumbs) {
    $breadcrumbs->parent('adminSettings');
    $breadcrumbs->push('Партнеры', route('adminSettingsPartners'));
});
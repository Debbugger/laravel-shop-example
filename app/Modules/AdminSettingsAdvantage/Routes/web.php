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

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/settings/advantage/'], function () {
    Route::get('/', 'AdvantageController@index')->name('adminSettingsAdvantage');
    Route::get('table', 'AdvantageController@table')->name('adminSettingsAdvantageTable');
    Route::post('create', 'AdvantageController@create')->name('adminSettingsAdvantageCreate');
    Route::post('edit', 'AdvantageController@edit')->name('adminSettingsAdvantageEdit');
    Route::post('delete', 'AdvantageController@delete')->name('adminSettingsAdvantageDelete');
    Route::post('modal', 'AdvantageController@getModal')->name('adminSettingsAdvantageModal');
    Route::post('changeShow','AdvantageController@changeShow')->name('adminSettingsAdvantageChangeShow');
    Route::post('image','AdvantageController@image')->name('adminSettingsAdvantageImage');
});
Breadcrumbs::register('adminSettingsAdvantage', function ($breadcrumbs) {
    $breadcrumbs->parent('adminSettings');
    $breadcrumbs->push('Преимущества', route('adminSettingsAdvantage'));
});
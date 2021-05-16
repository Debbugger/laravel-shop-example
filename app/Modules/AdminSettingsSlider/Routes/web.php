<?php

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/settings/sliders'], function () {
    Route::get('/', 'SliderController@index')->name('adminSettingsSlider');
    Route::get('table/','SliderController@table')->name('adminSettingsSliderTable');
    Route::match(['get','post'],'/edit','SliderController@edit')->name('adminSettingsSliderEdit');
    Route::post('create','SliderController@create')->name('adminSettingsSliderCreate');
    Route::post('delete','SliderController@delete')->name('adminSettingsSliderDelete');
    Route::post('image','SliderController@image')->name('adminSettingsSliderImage');
    Route::post('modal','SliderController@getModal')->name('adminSettingsSliderModal');
    Route::post('changeShow','SliderController@changeShow')->name('adminSettingsSliderChangeShow');
});
Breadcrumbs::register('adminSettingsSlider', function ($breadcrumbs) {
    $breadcrumbs->parent('adminSettings');
    $breadcrumbs->push('Слайды', route('adminSettingsSlider'));
});
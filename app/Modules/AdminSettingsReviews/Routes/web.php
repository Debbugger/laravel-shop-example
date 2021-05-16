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

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/settings/reviews'], function () {
    Route::get('/', 'ReviewsController@index')->name('adminSettingsReviews');
    Route::get('table/','ReviewsController@table')->name('adminSettingsReviewsTable');
    Route::match(['get','post'],'/edit','ReviewsController@edit')->name('adminSettingsReviewsEdit');
    Route::post('delete','ReviewsController@delete')->name('adminSettingsReviewsDelete');
    Route::post('image','ReviewsController@image')->name('adminSettingsReviewsImage');
    Route::post('modal','ReviewsController@getModal')->name('adminSettingsReviewsModal');
    Route::post('changeShow','ReviewsController@changeShow')->name('adminSettingsReviewsChangeShow');
});
Breadcrumbs::register('adminSettingsReviews', function ($breadcrumbs) {
    $breadcrumbs->parent('adminSettings');
    $breadcrumbs->push('Отзывы', route('adminSettingsReviews'));
});
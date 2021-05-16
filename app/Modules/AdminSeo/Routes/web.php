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

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url') . '/settings/seo'], function () {
    Route::match(['GET', 'POST'],'/', 'SeoController@all')->name('adminSeo');
    Route::post('delete', 'SeoController@deleteItem')->name('adminSeoDelete');
    Route::match(['GET', 'POST'],'seo', 'SeoController@seo')->name('adminCreateOrEditSeo');
});

Breadcrumbs::register('adminSeo', function ($breadcrumbs) {
    $breadcrumbs->parent('adminSettings');
    $breadcrumbs->push('SEO', route('adminSeo'));
});

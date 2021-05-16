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

Route::group(['prefix' => config('app.admin_url') . '/news/'], function () {
    Route::match(['get', 'post'], '/', 'PagesController@all')->name('adminNews');
    Route::match(['get', 'post'], 'add', 'PagesController@add')->name('adminNewsAddPage');
    Route::match(['get', 'post'], 'edit/{id}', 'PagesController@edit')->name('adminNewsEditPage');
    Route::post( 'editImage/{id}', 'PagesController@editImage')->name('adminNewsEditPageImage');
    Route::post('delete/image', 'PagesController@deleteImage')->name('adminNewsPageDeleteImage');
    Route::post('delete/article', 'PagesController@deleteItem')->name('adminNewsDeletePage');
    Route::post('change/show','PagesController@changeShow')->name('adminNewsChangeShow');
    Route::post('modal/seo','PagesController@getSeoModal')->name('adminNewsSeoModal');
    Route::post('seo','PagesController@changeSeo')->name('adminNewsChangeSeo');
});

Breadcrumbs::for('adminNews', function ($trail) {
    $trail->parent('adminHome');
    $trail->push('Новости', route('adminNews'));
});

Breadcrumbs::for('adminNewsAddPage', function ($trail) {
    $trail->parent('adminNews');
    $trail->push('Добавление', route('adminNewsAddPage'));
});

Breadcrumbs::for('adminNewsEditPage', function ($trail, $item) {
    $trail->parent('adminNews');
    $trail->push('Редактирование', route('adminNewsEditPage', $item->id));
});


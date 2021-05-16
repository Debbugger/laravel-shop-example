<?php


Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/discount/'], function () {
    Route::get('/', 'DiscountController@index')->name('adminDiscount');
    Route::get('table', 'DiscountController@table')->name('adminDiscountTable');
    Route::match(['get','post'],'create', 'DiscountController@create')->name('adminDiscountCreate');
    Route::match(['get','post'],'edit/{id}', 'DiscountController@edit')->name('adminDiscountEdit');
    Route::post('delete', 'DiscountController@delete')->name('adminDiscountDelete');
    Route::post('modal', 'DiscountController@getModal')->name('adminDiscountModal');
    Route::post('changeShow','DiscountController@changeShow')->name('adminDiscountChangeShow');
    Route::post('image','DiscountController@image')->name('adminDiscountImage');
    Route::post('modal/seo','DiscountController@getSeoModal')->name('adminDiscountSeoModal');
    Route::post('seo','DiscountController@changeSeo')->name('adminDiscountChangeSeo');
});
Breadcrumbs::register('adminDiscount', function ($breadcrumbs) {
    $breadcrumbs->parent('adminHome');
    $breadcrumbs->push('Акции', route('adminDiscount'));
});
Breadcrumbs::for('adminDiscountCreate', function ($trail, $item = null) {
    $trail->parent('adminDiscount');
    $trail->push('Создать', route('adminDiscountCreate', $item));
});
Breadcrumbs::for('adminDiscountEdit', function ($trail, $item = null) {
    $trail->parent('adminDiscount');
    $trail->push('Редактировать', route('adminDiscountEdit', $item));
});
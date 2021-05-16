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

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url').'/users'], function () {
    Route::get('/', 'UsersController@index')->name('adminUsers');
    Route::get('user-table', 'UsersController@userTable')->name('adminUsersTable');
    Route::match(['get', 'post'], 'edit/{id}','UsersController@edit')->name('adminUsersEdit');
    Route::post('edit/{id}/pass','UsersController@editPass')->name('adminUsersEditPass');
});
Breadcrumbs::for('adminUsers', function ($trail) {
    $trail->parent('adminHome');
    $trail->push('Пользователи', route('adminUsers'));
});
// Home > About
Breadcrumbs::for('adminUsersEdit', function ($trail, $user = null) {
    $trail->parent('adminUsers');
    $trail->push('Редактировать профиль', route('adminUsersEdit', $user));
});
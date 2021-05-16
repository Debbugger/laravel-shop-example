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

Route::get(LaravelLocalization::setLocale().config('app.admin_url') . '/management', 'ManagementController')->name('adminManagement');

Breadcrumbs::register('adminManagement', function ($breadcrumbs) {
    $breadcrumbs->parent('adminHome');
    $breadcrumbs->push('Управление товарами', route('adminManagement'));
});
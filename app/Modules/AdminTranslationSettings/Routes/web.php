<?php

Route::group(['prefix' => LaravelLocalization::setLocale().config('app.admin_url') . '/settings/translations'], function () {
    Route::get('/', 'TranslationController@groups')->name('adminTranslationSetting');
    Route::match(['get', 'post'], 'add', 'TranslationController@add')->name('adminTranslationAdd');
    Route::get('{group}', 'TranslationController@group')->name('adminTranslationGroup');
    Route::match(['get', 'post'],'add/{group}', 'TranslationController@add')->name('adminTranslationGroupAdd');
    Route::match(['get', 'post'], '{group}/{id}', 'TranslationController@edit')->name('adminTranslationEdit');
    Route::post('delete', 'TranslationController@delete')->name('adminTranslationDeleteGroup');
});

Breadcrumbs::register('adminTranslationSetting', function ($breadcrumbs) {
    $breadcrumbs->parent('adminSettings');
    $breadcrumbs->push('Переводы', route('adminTranslationSetting'));
});

Breadcrumbs::register('adminTranslationAdd', function ($breadcrumbs) {
    $breadcrumbs->parent('adminTranslationSetting');
    $breadcrumbs->push('Создание группы', route('adminTranslationAdd'));
});

Breadcrumbs::register('adminTranslationGroup', function ($breadcrumbs, $group) {
    $breadcrumbs->parent('adminTranslationSetting');
    $breadcrumbs->push('Управление группой', route('adminTranslationGroup', ['group' => $group]));
});

Breadcrumbs::register('adminTranslationGroupAdd', function ($breadcrumbs, $group) {
    $breadcrumbs->parent('adminTranslationGroup', $group);
    $breadcrumbs->push('Создание записи', route('adminTranslationGroupAdd', ['group' => $group]));
});

Breadcrumbs::register('adminTranslationEdit', function ($breadcrumbs, $group, $item) {
    $breadcrumbs->parent('adminTranslationGroup', $group);
    $breadcrumbs->push('Редактирование записи', route('adminTranslationEdit', ['group' => $group, 'item' => $item]));
});
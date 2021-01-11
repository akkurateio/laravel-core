<?php

Route::group([
    'namespace' => 'Akkurate\LaravelCore\Http\Controllers\Admin\Api',
    'middleware' => config('laravel-admin.routes.api.middleware'),
    'prefix' => config('laravel-admin.routes.api.prefix'),
    'as' => config('laravel-admin.routes.api.as')], function () {

    Route::apiResource('countries', 'CountryController');
    Route::apiResource('languages', 'LanguageController');
    Route::apiResource('accounts', 'AccountController');

    /**
     * Route api pour récupérer et attacher les users aux accounts
     */
    Route::get('accounts/{account}/users', 'AccountController@findUsers')->name('find.users');
    Route::post('accounts/{account}/users/attach', 'AccountController@attachUser')->name('attach.user');
    Route::post('accounts/{account}/users/detach', 'AccountController@detachUser')->name('detach.user');

    Route::apiResource('users', 'UserController')->except('store');
});

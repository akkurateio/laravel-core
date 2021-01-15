<?php

Route::group([
    'namespace' => 'Akkurate\LaravelCore\Http\Controllers\Admin\Back',
    'middleware' => config('laravel-admin.routes.back.middleware'),
    'prefix' => config('laravel-admin.routes.back.prefix'),
    'as' => config('laravel-admin.routes.back.as')], function () {
    Route::post('users/{user}/roles/assign', 'UserController@assignRole')->name('users.roles.assign');
    Route::patch('users/{user}/toggle', 'UserController@toggle')->name('users.toggle');
    Route::resource('users', 'UserController')->except(['create', 'store']);
    Route::patch('accounts/{account}/toggle', 'AccountController@toggle')->name('accounts.toggle');
    Route::resource('accounts', 'AccountController');
    Route::resource('preferences', 'PreferenceController')->only('update');
});

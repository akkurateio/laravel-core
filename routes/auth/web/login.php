<?php

Route::group(['middleware' => 'web'], function() {

    // Authentication Routes...
    Route::get('login', [
        'as' => 'login',
        'uses' => 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\LoginController@showLoginForm'
    ]);
    Route::post('login', [
        'as' => '',
        'uses' => 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\LoginController@login'
    ]);
    Route::match(['get', 'post'], 'logout', [
        'as' => 'logout',
        'uses' => 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\LoginController@logout'
    ]);

    // Password Reset Routes...
    Route::post('password/email', [
        'as' => 'password.email',
        'uses' => 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\ForgotPasswordController@sendResetLinkEmail'
    ]);
    Route::get('password/reset', [
        'as' => 'password.request',
        'uses' => 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\ForgotPasswordController@showLinkRequestForm'
    ]);
    Route::post('password/reset', [
        'as' => 'password.update',
        'uses' => 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\ResetPasswordController@reset'
    ]);
    Route::get('password/reset/{token}', [
        'as' => 'password.reset',
        'uses' => 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\ResetPasswordController@showResetForm'
    ]);

});


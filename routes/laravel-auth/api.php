<?php

Route::group(['middleware' => 'api', 'prefix' => 'api/v1', 'as' => 'api.'], function() {
    // PUBLIC ROUTES
    Route::post('auth/login', 'Akkurate\LaravelCore\Http\Controllers\Auth\Api\LoginController@login')->name('auth.login');
    Route::post('auth/register', 'Akkurate\LaravelCore\Http\Controllers\Auth\Api\RegisterController@register')->name('auth.register');
    Route::post('auth/password/reset', Akkurate\LaravelCore\Http\Controllers\Auth\Api\ForgotPasswordController::class)->name('auth.password.reset');

    // PRIVATE ROUTES
    Route::middleware('auth:api')->group(function () {
        Route::post('auth/logout', 'Akkurate\LaravelCore\Http\Controllers\Auth\Api\LoginController@logout')->name('auth.logout');
        Route::post('auth/{user}/password/update', 'Akkurate\LaravelCore\Http\Controllers\Auth\Api\Password@update')->name('auth.password.update');
    });
});

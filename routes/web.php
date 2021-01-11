<?php

Route::group(['middleware' => config('laravel-core.admin.middleware')], function () {
    Route::redirect('home', config('laravel-core.admin.route'));
    Route::redirect('admin', config('laravel-core.admin.route'));
    Route::get(config('laravel-core.admin.route'), [\Akkurate\LaravelCore\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::get(config('laravel-core.admin.route').'/{uuid}', [\Akkurate\LaravelCore\Http\Controllers\AdminController::class, 'brain'])
        ->middleware('account')
        ->name('brain');
});
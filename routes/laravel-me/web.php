<?php

use Akkurate\LaravelCore\Http\Controllers\Me\Back\ProfileController;
use Akkurate\LaravelCore\Http\Controllers\Me\Back\PreferenceController;
use Akkurate\LaravelCore\Http\Controllers\Me\Back\PasswordController;
use Akkurate\LaravelCore\Http\Controllers\Me\Back\AccountController;
use Akkurate\LaravelCore\Http\Controllers\Me\Back\UserController;

Route::group([
    'middleware' => config('laravel-me.routes.back.middleware'),
    'prefix' => config('laravel-me.routes.back.prefix'),
    'as' => config('laravel-me.routes.back.as')], function () {

    Route::redirect('/', 'me/profile');

    //Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    //Preferences
    Route::get('preferences', [PreferenceController::class, 'edit'])->name('preferences.edit');
    Route::put('preferences', [PreferenceController::class, 'update'])->name('preferences.update');

    //Password
    Route::get('password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    //Account
    Route::get('account/create', [AccountController::class, 'create'])->name('account.create')->middleware('permission:create account');
    Route::post('account/create', [AccountController::class, 'store'])->name('account.store')->middleware('permission:create account');
    Route::get('account', [AccountController::class, 'edit'])->name('account.edit')->middleware('permission:update account');
    Route::put('account', [AccountController::class, 'update'])->name('account.update')->middleware('permission:update account');

    //User
    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('permission:update account');
    Route::get('users/{userUuid}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:update account');
    Route::put('users/{userUuid}/update', [UserController::class, 'update'])->name('users.update')->middleware('permission:update account');
    Route::delete('users/{userUuid}/soft-delete', [UserController::class, 'softDelete'])->name('users.soft-delete')->middleware('permission:update account');
    Route::get('users/invit', [UserController::class, 'create'])->name('users.create')->middleware('permission:update account');
    Route::post('users/invit', [UserController::class, 'store'])->name('users.store')->middleware('permission:update account');
    Route::get('users/toggle/{userUuid}', [UserController::class, 'toggle'])->name('users.toggle')->middleware('permission:update account');
    Route::get('users/reinvit/{userUuid}', [UserController::class, 'reinvit'])->name('users.reinvit')->middleware('permission:update account');
});

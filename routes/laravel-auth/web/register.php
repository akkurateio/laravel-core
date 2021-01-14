<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

Route::group(['middleware' => 'web'], function() {

    // Registration Routes...
    Route::get('register', [
        'as' => 'register',
        'uses' => 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\RegisterController@showRegistrationForm'
    ]);
    Route::post('register', [
        'as' => '',
        'uses' => config('laravel-auth.register_controller')
    ]);

    Route::get('register/complete-profile', 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\InvitationController@editProfile')->name('register.profile.edit')->middleware('auth');
    Route::patch('register/complete-profile', 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\InvitationController@updateProfile')->name('register.profile.update');

});


<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

Route::group(['middleware' => 'web'], function() {

    // Email Verification Routes...
    Route::get('/email/verify', function () {
        return view('auth::verify');
    })->middleware(['auth'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect(config('laravel-core.admin.route'));
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    Route::get('/verify-user/{token}', 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\InvitationController@verifyUser')->name('verify.user');

});


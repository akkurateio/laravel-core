<?php

Route::group([
    'namespace' => 'Akkurate\LaravelCore\Http\Controllers\Access\Back',
    'middleware' => config('laravel-access.routes.back.middleware'),
    'prefix' => config('laravel-access.routes.back.prefix'),
    'as' => config('laravel-access.routes.back.as')
], function () {
    Route::group(['middleware' => 'permission:manage roles'], function(){
        Route::resource('roles', 'RoleController');
        Route::post('roles/{role}/{permission}/revoke', 'RoleController@revokePermission')->name('roles.permission.revoke');
        Route::post('roles/{role}/permission', 'RoleController@givePermission')->name('roles.permission.give');
    });
    Route::group(['middleware' => 'permission:manage permissions'], function(){
        Route::resource('permissions', 'PermissionController');
        Route::post('permissions/{modelUuid}/revoke', 'PermissionController@revokePermission')->name('permission.revoke');
        Route::post('permissions/{modelUuid}/give', 'PermissionController@givePermission')->name('permission.give');
    });
});


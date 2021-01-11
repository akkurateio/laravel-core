<?php
Route::group([
    'namespace' => 'Akkurate\LaravelCore\Http\Controllers\Access\Api',
    'middleware' => config('laravel-access.routes.api.middleware'),
    'prefix' => config('laravel-access.routes.api.prefix'),
    'as' => config('laravel-access.routes.api.as')
], function() {
    Route::apiResource('roles', 'RoleController');
    Route::group(['middleware' => 'permission:manage roles'], function(){
        Route::post('roles/{role}/permissions/{permission}', 'RoleController@givePermission')->name('roles.permission.give');
        Route::post('roles/{role}/permissions/{permission}/revoke', 'RoleController@revokePermission')->name('roles.permission.revoke');
    });
    Route::apiResource('permissions', 'PermissionController');
    Route::group(['middleware' => 'permission:manage permissions'], function(){
        Route::post('permissions/{permission}/models/{modelUuid}', 'PermissionController@givePermission')->name('permission.give');
        Route::post('permissions/{permission}/models/{modelUuid}/revoke', 'PermissionController@revokePermission')->name('permission.revoke');
    });
});

<?php

return [
    'api_enabled' => true,
    'allow_register' => false,
    'redirect_user_after_registration' => config('laravel-core.admin.route'),
    'verify_email' => true,
    'register_middleware' => ['role:superadmin'],
    'register_controller' => 'Akkurate\LaravelCore\Http\Controllers\Auth\Back\RegisterController@register',
];


<?php

namespace Akkurate\LaravelCore\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class CoreKernel extends HttpKernel
{
    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
        ],

        'akk-back' => [
            \Akkurate\LaravelCore\Http\Middleware\Back\CheckUserStatus::class,
            \Akkurate\LaravelCore\Http\Middleware\Back\Account::class,
        ],

        'akk-api' => [
            \Akkurate\LaravelCore\Http\Middleware\Api\UserActive::class,
            \Akkurate\LaravelCore\Http\Middleware\Api\AccountExists::class,
            \Akkurate\LaravelCore\Http\Middleware\Api\AccountAdministrator::class,
            \Akkurate\LaravelCore\Http\Middleware\Api\JsonMiddleware::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
        'account' => \Akkurate\LaravelCore\Http\Middleware\Back\Account::class,
    ];
}

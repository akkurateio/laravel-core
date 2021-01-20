<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    */
    'routes' => [
        'api' => [
            'enabled' => true,
            'middleware' => ['api','auth:api','akk-api','permission:access'],
            'prefix' => 'api/v1/accounts/{uuid}/packages/access',
            'as' => 'api.access.'
        ],
        'back' => [
            'enabled' => true,
            'middleware' => ['web', 'auth', 'akk-back', 'permission:access'],
            'prefix' => 'brain/{uuid}/access',
            'as' => 'brain.access.'
        ],
    ],

    'label' => 'Administration',

    'deactivated-user-can-access-profile' => env('DEACTIVATED_USER_CAN_ACCESS_PROFILE', true),
    'redirect_user' => '/',
    'default_role' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Package Architecture
    |--------------------------------------------------------------------------
    |
    */
    'archi' => [
        'accounts' => [
            'menu' => true,
            'label' => 'Comptes',
            'route' => 'brain.admin.accounts.index',
        ],
        'users' => [
            'menu' => true,
            'label' => 'Utilisateurs',
            'route' => 'brain.admin.users.index',
        ],
        'roles' => [
            'menu' => true,
            'label' => 'Rôles',
            'route' => 'brain.access.roles.index',
        ],
        'permissions' => [
            'menu' => true,
            'label' => 'Permissions',
            'route' => 'brain.access.permissions.index',
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | Information for building index views
   |--------------------------------------------------------------------------
   |
   */
    'cruds' => [
        'Permission' => [
            'views' => [
                'index' => [
                    'template' => 'table',
                    'columns' => ['package', 'name', 'label'],
                ],
            ],
        ],
        'Role' => [
            'views' => [
                'index' => [
                    'template' => 'table',
                    'columns' => ['name', 'label'],
                ],
            ],
        ],
    ],
];

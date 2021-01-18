<?php

return [

    'label' => 'Administration',

    'legal_info' => env('ACCOUNT_LEGAL_INFO', false),

    'account_internal_reference' => env('ACCOUNT_INTERNAL_REFERENCE', false),

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    */
    'routes' => [
        'api' => [
            'enabled' => true,
            'middleware' => ['api', 'auth:api', 'akk-api', 'permission:admin'],
            'prefix' => 'api/v1/accounts/{uuid}/packages/admin',
            'as' => 'api.admin.'
        ],
        'back' => [
            'enabled' => true,
            'middleware' => ['web', 'auth', 'akk-back', 'permission:admin'],
            'prefix' => 'brain/{uuid}/admin',
            'as' => 'brain.admin.'
        ],
    ],

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
    ]
];

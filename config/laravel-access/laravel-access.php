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
    | Access Package Seeds
    |--------------------------------------------------------------------------
    |
    */

    /*
     * Permissions
     */
    'permissions' => [
        ['name' => 'access', 'label' => 'Accéder au module Access'],
        ['name' => 'manage roles', 'label' => 'Administrer les rôles'],
        ['name' => 'list roles', 'label' => 'Afficher la liste des rôles'],
        ['name' => 'create role', 'label' => 'Créer un rôle'],
        ['name' => 'read role', 'label' => 'Voir le détail d’un rôle'],
        ['name' => 'update role', 'label' => 'Mettre à jour un rôle'],
        ['name' => 'delete role', 'label' => 'Supprimer un rôle'],
        ['name' => 'manage permissions', 'label' => 'Administrer les permissions'],
        ['name' => 'list permissions', 'label' => 'Afficher la liste des permissions'],
        ['name' => 'create permission', 'label' => 'Créer une permission'],
        ['name' => 'read permission', 'label' => 'Voir le détail d’une permission'],
        ['name' => 'update permission', 'label' => 'Mettre à jour une permission'],
        ['name' => 'delete permission', 'label' => 'Supprimer une permission'],
    ],

    'roles' => [
        ['name' => 'superadmin', 'label' => 'super administrateur'],
        ['name' => 'admin', 'label' => 'administrateur'],
        ['name' => 'user', 'label' => 'utilisateur'],
        ['name' => 'bot', 'label' => 'machine'],
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

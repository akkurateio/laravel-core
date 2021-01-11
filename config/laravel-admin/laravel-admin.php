<?php

return [

    'label' => 'Administration',

    'legal_info' => env('ACCOUNT_LEGAL_INFO', false),

    'account_internal_reference' => env('ACCOUNT_INTERNAL_REFERENCE', false),

    'default-password' => env('DEFAULT_PASSWORD', 'password'),

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
        'countries' => [
            'menu' => false,
            'label' => 'Pays',
            'route' => 'brain.admin.countries.index',
        ],
        'languages' => [
            'menu' => false,
            'label' => 'Langues',
            'route' => 'brain.admin.languages.index',
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
     * Package CRUDs
     */
    'cruds' => [
        'Country' => [
            'views' => [
                'index' => [
                    'template' => 'table',
                    'columns' => ['id', 'name',],
                    'main' => 'name',
                ],
            ],
        ],
        'Language' => [
            'views' => [
                'index' => [
                    'template' => 'table',
                    'columns' => ['id', 'locale',],
                    'main' => 'locale',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Package Seeds
    |--------------------------------------------------------------------------
    |
    */

    /*
    * Permissions
    */
    'permissions' => [
        ['name' => 'admin', 'label' => 'Accéder au module Admin'],
        ['name' => 'list users', 'label' => 'Afficher la liste des utilisateurs'],
        ['name' => 'create user', 'label' => 'Créer un utilisateur'],
        ['name' => 'read user', 'label' => 'Voir le détail d’un utilisateur'],
        ['name' => 'update user', 'label' => 'Mettre à jour un utilisateur'],
        ['name' => 'delete user', 'label' => 'Supprimer un utilisateur'],
        ['name' => 'list accounts', 'label' => 'Afficher la liste des compte'],
        ['name' => 'create account', 'label' => 'Créer un compte'],
        ['name' => 'read account', 'label' => 'Voir le détail d’un compte'],
        ['name' => 'update account', 'label' => 'Mettre à jour un compte'],
        ['name' => 'delete account', 'label' => 'Supprimer un compte'],
    ],

    /*
    * Roles
    */
    'roles' => [
        //
    ],

    /*
    * Roles’ permissions
    */
    'roles_permissions' => [
        'user' => [
            'create account'
        ],
        'admin' => [
            'admin',
            'list users',
            'read user',
            'update user',
            'delete user',
            'read account',
            'update account',
            'delete account',
        ]
    ],

    /*
     * Accounts
     */
    'accounts' => [
        [
            'params' => [
                'registry_siret' => '000 000 000',
                'registry_rcs' => 'Montpellier',
                'registry_intra' => 'FR01012345687',
                'capital' => '',
                'ape' => '',
                'legal_form_id' => 'S.A.S.'
            ],
            'email' => 'hello@akkurate.com',
            'name' => 'Akkurate',
            'website' => 'https://www.akkurate.io/#welcome',
            'country_id' => 1,
            'phones' => [
                [
                    'type' => 'WORK',
                    'number' => '0110101010',
                ]
            ],
            'addresses' => [
                [
                    'type' => 'WORK',
                    'name' => 'Akkurate',
                    'street1' => '48 rue Maurice Béjart',
                    'zip' => '34080',
                    'city' => 'Montpellier'
                ]
            ],
            'emails' => [
                [
                    'type' => 'WORK',
                    'name' => 'Général',
                    'email' => 'hello@akkurate.com'
                ]
            ]
        ],
        [
            'parent_id' => 1,
            'name' => 'First Demo',
            'email' => 'hello@demo1.com',
            'country_id' => 1,
        ],
        [
            'name' => 'Second Demo',
            'email' => 'hello@demo2.com',
            'country_id' => 1,
        ],
    ],

    /*
    * Users
    */
    'users' => [
        [
            'role' => 'superadmin',
            'account_id' => 1,
            'firstname' => 'Username',
            'lastname' => 'Superadmin',
            'email' => [
                'type' => 'WORK',
                'address' => 'username.superadmin@test.com'
            ],
            'gender' => 'M'
        ],
        [
            'role' => 'admin',
            'account_id' => 1,
            'firstname' => 'Username',
            'lastname' => 'Admin',
            'email' => [
                'type' => 'WORK',
                'address' => 'username.admin@test.com'
            ],
            'gender' => 'M',
            'phone' =>
                [
                    'type' => 'HOME',
                    'number' => '0601010101'
                ]
        ],
        [
            'role' => 'user',
            'account_id' => 1,
            'firstname' => 'Username',
            'lastname' => 'User',
            'email' => [
                'type' => 'WORK',
                'address' => 'username.user@test.com'
            ],
            'gender' => 'M'
        ],
    ]
];

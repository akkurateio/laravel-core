<?php

return [

    'label' => 'Mon compte',

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    */
    'routes' => [
        'back' => [
            'enabled' => true,
            'middleware' => ['web', 'auth'],
            'prefix' => 'brain/{uuid}/me',
            'as' => 'brain.me.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Invitations
    |--------------------------------------------------------------------------
    |
    */
    'send_invitation' => true,

    /*
    |--------------------------------------------------------------------------
    | Roles into update user form
    |--------------------------------------------------------------------------
    |
    */
    'roles' => [
        'user' => [
            'name' => 'Utilisateur',
            'overview' => ''
        ],
        'admin' => [
            'name' => 'Administrateur',
            'overview' => ''
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Extends on the package default behavior
    |--------------------------------------------------------------------------
    |
    */
    'extends' => [
        /*
        |--------------------------------------------------------------------------
        | Custom preferences forms
        |--------------------------------------------------------------------------
        |
        */
        'preferences' => null
//          [
//            [
//                'guard' => 'Ex: update account preferences',
//                'title' => 'Ex: Update account preferences',
//                'formId' => 'Ex: accountPreferencesForm',
//                'formClass' => 'Ex: \Akkurate\LaravelMe\Forms\AccountPreferenceForm',
//                'routeSubmit' => 'Ex: brain.me.account.preferences.update'
//            ]
//        ],
    ]
];

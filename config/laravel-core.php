<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Routes (back-office)
    |--------------------------------------------------------------------------
    |
    */
    'admin' => [
        /**
         * Defines the default redirect route
         */
        'route' => 'brain',
        /**
         * Defines the default middlewares
         */
        'middleware' => ['web', 'auth', 'verified']
    ]
];

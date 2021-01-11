<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    |
    | General configuration variables used by the whole project.
    |
    */
    'GA' => '',
    'GTM' => '',
    'locale' => 'fr_FR',
    'timeZone' => 'Europe/Paris',
    'owner' => 'Akkurate',
    'name' => 'Laravel Boilerplate',
    'baseline' => 'Intelligent Design for Business',
    'homepage' => 'front.homepage',
    'description' => 'Akkurate Laravel Boilerplate, pour des projets performants et évolutifs',
    'address' => [
        'street1' => '48, rue Maurice Béjart',
        'street2' => '',
        'zip' => '34080',
        'city' => 'Montpellier',
        'country' => 'France',
        'area' => 'Occitanie',
        'countryCode' => 'FR',
        'latitude' => 3.8249249,
        'longitude' => 43.6172636,
    ],

    /**
     * Change the info key to customize your newsletter info message.
     */
    'newsletter' => [
        'info' => 'En renseignant votre mail, vous acceptez de recevoir chaque semaine de nos nouvelles :)',
    ],
    /**
     * Signature options visible in the show account view.
     */
    'signature' => [
        /**
         * Options for your logo.
         */
        'logotype' => [
            /**
             * Defines the source of your logo's picture.
             */
            'src' => '/images/mail/Subvitamine-logotype-full-cobalt.png',
            /**
             * Defines the size of your logo.
             *
             * Default : width 180, height 180
             */
            'size' => [
                'width' => 180,
                'height' => 180,
            ],
        ],
        /**
         * Defines the url of your site.
         */
        'sitename' => 'https://www.akkurate.io/#welcome',
    ],
    /**
     * Contact options visible in the footer of your emails and in your signature.
     */
    'contact' => [
        'phone' => '01 45 21 05 21',
        'email' => [
            'general' => 'hello@akkurate.com'
        ]
    ],
    /**
     * Socials options visible in the footer of your emails and in your signature.
     */
    'socials' => [
        'linkedin' => 'https://www.linkedin.com/company/akkurate/',
        'twitter' => 'https://twitter.com/Akkurate_io'
    ],
    /**
     * Meta options
     */
    'meta' => [
        'twitter' => [
            'site' => '@akkurate',
            'creator' => '@akkurate',
        ]
    ],
    /**
     * Registry options
     */
    'registry' => [
        'legalForm' => 'S.A.S.',
        'capital' => 85170,
        'number' => '449 326 826',
        'location' => 'Montpellier',
        'interNumber' => 'FR08449326826',
    ],

    /**
     * Protocol option
     */
    'protocol' => "http",

    /**
     * Defines your site map.
     */
    'sitemap' => [
        //
    ],

    /**
     * Defines the default theme of the application.
     * If you want to customize your interfaces, you can set the ENV variable to change the theme.
     */
    'theme' => env('APP_THEME', 'default'),
];




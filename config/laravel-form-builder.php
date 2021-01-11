<?php

return [
    /**
     * Defines your custom fields for the Laravel FormBuilder forms.
     */
    'custom_fields' => [
        'select-vue' => Akkurate\LaravelCore\Forms\Fields\SelectVue::class,
        'selectandsearch-vue' => Akkurate\LaravelCore\Forms\Fields\SelectAndSearchVue::class,
        'addresses' => Akkurate\LaravelCore\Forms\Fields\AddressesComponent::class,
    ]
];

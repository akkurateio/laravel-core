<?php

namespace Akkurate\LaravelCore\Forms\Me;

use Kris\LaravelFormBuilder\Form;

class AccountForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => __('Nom de l’organisation')
            ])
            ->add('website', 'text', [
                'label' => __('Adresse de votre site Internet'),
                'attr' => [
                    'placeholder' => 'https://...'
                ]
            ]);

        if (config('laravel-admin.account_internal_reference')) {
            $this->add('internal_reference', 'text', [
                'label' => __('Référence interne d’identification'),
                'attr' => [
                    'placeholder' => 'Ex. : MON-ORGANISATION-1'
                ]
            ]);
        }

        if (config('laravel-admin.legal_info')) {
            $this->add('siren', 'text', ['label' => __('SIREN')]);
        }

    }
}

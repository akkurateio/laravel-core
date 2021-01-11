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
            ])
            ->add('internal_reference', 'text', [
                'label' => __('Référence interne d’identification'),
                'attr' => [
                    'placeholder' => 'Ex. : MON-ORGANISATION-1'
                ]
            ])
            ->add('siren', 'text', [
                'label' => __('SIREN')
            ])
        ;
    }
}

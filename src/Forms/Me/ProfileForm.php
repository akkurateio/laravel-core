<?php

namespace Akkurate\LaravelCore\Forms\Me;

use Kris\LaravelFormBuilder\Form;

class ProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('lastname', 'text', [
                'label' => __('Nom')
            ])
            ->add('firstname', 'text', [
                'label' => __('Prénom')
            ])
            ->add('email', 'email', [
                'label' => __('Email')
            ])
            ->add('birth_date', 'date', [
                'label' => __('Date de naissance')
            ])
            ->add('gender', 'select', [
                'label' => __('Civilité'),
                'choices' => [
                    'N' => 'Neutre',
                    'M' => 'Monsieur',
                    'F' => 'Madame',
                ],
                'attr' => [
                    'class' => 'custom-select'
                ]
            ])
        ;
    }
}

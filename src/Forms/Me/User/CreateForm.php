<?php

namespace Akkurate\LaravelCore\Forms\Me\User;

use Kris\LaravelFormBuilder\Form;

class CreateForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('lastname', 'text', [
                'label' => __('Nom de l’invité'),
            ])
            ->add('firstname', 'text', [
                'label' => __('Prénom de l’invité'),
            ])
            ->add('email', 'email', [
                'label' => __('Email de l’invité'),
            ])
        ;
    }
}

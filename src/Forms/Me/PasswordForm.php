<?php

namespace Akkurate\LaravelCore\Forms\Me;

use Kris\LaravelFormBuilder\Form;

class PasswordForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('password_actual', 'password', [
                'label' => __('Votre mot de passe actuel'),
            ])
            ->add('password', 'repeated', [
                'type' => 'password',
                'second_name' => 'password_confirmation',
                'first_options' => [
                    'label' => __('Nouveau mot de passe'),
                ],
                'second_options' => [
                    'label' => __('Confirmation'),
                ],
            ])
        ;
    }
}

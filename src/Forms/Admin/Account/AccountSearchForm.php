<?php

namespace Akkurate\LaravelCore\Forms\Admin\Account;

use Kris\LaravelFormBuilder\Form;

class AccountSearchForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('q', 'text', [
                'wrapper' => [
                    'class' => 'form-group mb-3'
                ],
                'attr' => [
                    'class' => 'form-control border-none',
                    'placeholder' => __('Mot-clé'),
                ],
                'value' => request('q'),
                'label' => __('Rechercher parmi les comptes'),
                'label_attr' => [
                    'class' => 'text-white',
                    'rules' => 'required'
                ]
            ]);
    }
}

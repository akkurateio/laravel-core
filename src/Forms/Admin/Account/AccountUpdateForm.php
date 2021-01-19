<?php

namespace Akkurate\LaravelCore\Forms\Admin\Account;

use Kris\LaravelFormBuilder\Form;

class AccountUpdateForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => __('Name') . ' *', 'rules' => 'required|min:2|max:255', 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('email', 'text', ['label' => __('Email'), 'rules' => 'email', 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('website', 'text', ['label' => __('Website'), 'attr' => ['class' => 'form-control form-control-sm']]);

        if (config('laravel-i18n')) {
            $countries = \Akkurate\LaravelCore\Models\Country::where('is_active', 1)->get();
            $countriesSelect = $countries->pluck('name', 'id')->toArray();
            $this->add('country_id', 'select', ['label' => __('Pays'), 'rules' => 'integer', 'choices' => $countriesSelect, 'attr' => ['class' => 'form-control form-control-sm'], 'wrapper' => ['class' => 'mb-3']]);
        }

        if (config('laravel-admin.account_internal_reference')) {
            $this->add('internal_reference', 'text', ['label' => 'Référence interne', 'attr' => ['class' => 'form-control form-control-sm']]);
        }
    }
}

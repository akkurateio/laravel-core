<?php

namespace Akkurate\LaravelCore\Forms\Admin\User;

use Akkurate\LaravelCore\Models\Account;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;
use Spatie\Permission\Models\Role;

class UserSearchForm extends Form
{
    public function buildForm()
    {
        $accounts = Account::administrable()->active()->orderBy('name')->get();
        $accountsSelect = Arr::prepend($accounts->pluck('name', 'id')->toArray(), 'Tous', 0);

        $roles = Role::all();
        $rolesSelect = array_merge(['all' => __('Tous')], $roles->pluck('name', 'name')->toArray());

        $this
            ->add('q', 'search', [
                'attr' => [
                    'class' => 'form-control border-none',
                    'placeholder' => __('Mot-clé'),
                ],
                'value' => request('q'),
                'label' => __('Rechercher parmi les utilisateurs'),
                'label_attr' => [
                    'class' => 'text-white'
                ]
            ])
            ->add('role', 'select', [
                'attr' => [
                    'class' => 'custom-select custom-select-sm border-none'
                ],
                'selected' => request('role'),
                'label' => __('Rôle'),
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'choices' => $rolesSelect
            ])
            ->add('status', 'select', [
                'attr' => [
                    'class' => 'custom-select custom-select-sm border-none'
                ],
                'selected' => request('status'),
                'label' => __('Statut'),
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'choices' => [
                    'all' => __('Tous'),
                    'is_active' => __('Actif'),
                    'deactivated' => __('Désactivé')
                ]
            ])
            ->add('account', 'select', [
                'wrapper' => [
                    'class' => 'form-group mb-3'
                ],
                'attr' => [
                    'class' => 'custom-select custom-select-sm border-none'
                ],
                'selected' => request('account'),
                'label' => __('Compte'),
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'choices' => $accountsSelect
            ]);
    }
}

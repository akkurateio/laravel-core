<?php

namespace Akkurate\LaravelCore\Forms\Admin\User;

use Kris\LaravelFormBuilder\Form;

class UserUpdateForm extends Form
{
    public function buildForm()
    {
        $accounts = account()->where('is_active', 1)->orderBy('name', 'asc')->get();
        $accountsSelect = $accounts->pluck('name', 'id')->toArray();

        $this
            ->add('image', 'file', ['label' => __('Choisir un fichier'), 'wrapper' => ['class' => 'custom-file akk-mb-4'], 'attr' => ['class' => 'custom-file-input'], 'label_attr' => ['class' => 'custom-file-label']])
            ->add('lastname', 'text', ['label' => __('Nom') . ' *', 'rules' => 'required|min:2|max:255', 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('firstname', 'text', ['label' => __('Prénom') . ' *', 'rules' => 'required|min:2|max:255', 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('email', 'text', ['label' => __('Email'), 'rules' => 'max:255', 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('gender', 'select', ['label' => __('Civilité'), 'choices' => ['M' => __('Homme'),'F' => __('Femme'),'N' => __('Indéfini')] ,'attr' => [ 'class' => 'form-control form-control-sm']])
            ->add('account_id', 'select', ['label' => __('Compte de rattachement'), 'choices' => $accountsSelect ,'attr' => [ 'class' => 'custom-select']])
            ->add('birth_date', 'date', ['label' => __('Date de naissance'), 'attr' => [ 'class' => 'form-control form-control-sm', 'type' => 'date']])
            ->add('is_active', 'checkbox', ['label' => __('Actif'), 'wrapper' => ['class' => 'form-group custom-control custom-checkbox'], 'attr' => ['class' => 'custom-control-input'], 'label_attr' => ['class' => 'custom-control-label']]);
    }
}

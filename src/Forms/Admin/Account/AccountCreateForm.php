<?php

namespace Akkurate\LaravelCore\Forms\Admin\Account;

use Akkurate\LaravelCore\Models\Country;
use Akkurate\LaravelBusiness\Models\LegalForm;
use Kris\LaravelFormBuilder\Form;

class AccountCreateForm extends Form
{
    public function buildForm()
    {
        $countries = Country::where('is_active', 1)->get();
        $countriesSelect = $countries->pluck('name', 'id')->toArray();

        $this
            ->add('name', 'text', ['label' => __('Nom') . ' *', 'rules' => 'required|min:2|max:255'])
            ->add('email', 'text', ['label' => __('E-mail'), 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('website', 'text', ['label' => __('Site web'), 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('street1', 'text', ['label' => __('Rue 1') . ' *', 'rules' => 'required', 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('street2', 'text', ['label' => __('Rue 2'), 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('street3', 'text', ['label' => __('Rue 3'), 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('zip', 'text', ['label' => __('Code postal') . ' *', 'rules' => 'required', 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('city', 'text', ['label' => __('Ville') . ' *', 'rules' => 'required', 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('number', 'text', ['label' => __('Numéro de téléphone') . ' *', 'rules' => 'required', 'attr' => ['class' => 'form-control form-control-sm']])
            ->add('country_id', 'select', ['label' => __('Pays'), 'rules' => 'integer', 'choices' => $countriesSelect, 'attr' => ['class' => 'form-control form-control-sm']]);

        if (config('laravel-admin.account_internal_reference')) {
            $this->add('internal_reference', 'text', ['label' => 'Référence interne', 'attr' => ['class' => 'form-control form-control-sm']]);
        }

        if (config('laravel-admin.legal_info')) {
            $this->add('registry_siret', 'text', ['label' => __('SIRET'), 'attr' => ['class' => 'form-control form-control-sm']])
                ->add('registry_rcs', 'text', ['label' => __('RCS'), 'attr' => ['class' => 'form-control form-control-sm']])
                ->add('registry_intra', 'text', ['label' => __('TVA Intracommunautaire'), 'attr' => ['class' => 'form-control form-control-sm']])
                ->add('capital', 'number', ['label' => __('Capital'), 'attr' => ['class' => 'form-control form-control-sm']])
                ->add('ape', 'number', ['label' => __('Code APE'), 'attr' => ['class' => 'form-control form-control-sm']]);
        }

        if (config('laravel-business')) {
            $legal_formsSelect = LegalForm::all()->pluck('name', 'id')->toArray();
            if (count($legal_formsSelect) == 0) {
                $this->add('legal_form_id', 'select', ['label' => __('Forme juridique'), 'choices' => $legal_formsSelect, 'attr' => ['class' => 'form-control form-control-sm'], 'empty_value' => 'Vous devez ajoutez des formes juridiques']);
            } elseif (count($legal_formsSelect) == 1) {
                $this->add('legal_form_id', 'select', ['label' => __('Forme juridique'), 'choices' => $legal_formsSelect, 'attr' => ['class' => 'form-control form-control-sm']]);
            } elseif (count($legal_formsSelect) <= config('app.radio-limit')) {
                $this->add('legal_form_id', 'choice', ['label' => __('Forme juridique'), 'choices' => $legal_formsSelect, 'expanded' => true, 'multiple' => false, 'choice_options' => ['wrapper' => ['class' => 'custom-control custom-radio'], 'attr' => ['class' => 'custom-control-input'], 'label_attr' => ['class' => 'custom-control-label']]]);
            } else {
                $this->add('legal_form_id', 'select', ['label' => __('Forme juridique'), 'choices' => $legal_formsSelect, 'attr' => ['class' => 'form-control form-control-sm']]);
            }
        }
    }
}

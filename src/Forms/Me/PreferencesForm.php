<?php

namespace Akkurate\LaravelCore\Forms\Me;

use Kris\LaravelFormBuilder\Form;

class PreferencesForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('pagination', 'select', [
                'label' => __('Nombre d’entrées par page'),
                'choices' => [
                    '10' => __(':value entrées par page', ['value' => 10]),
                    '30' => __(':value entrées par page', ['value' => 30]),
                    '90' => __(':value entrées par page', ['value' => 90]),
                    '150' => __(':value entrées par page', ['value' => 150]),
                    '250' => __(':value entrées par page', ['value' => 250]),
                ],
                'attr' => [
                    'class' => 'custom-select'
                ]
            ]);

        if (config('laravel-i18n')) {
            $languages = \Akkurate\LaravelCore\Models\Language::orderBy('locale_php', 'asc')->get();
            $languagesChoices = [];
            foreach ($languages as $language) {
                $languagesChoices[$language->id] = $language->locale_php;
            }
            $this->add('language_id', 'select', [
                'label' => __('Langue de l’application'),
                'choices' => $languagesChoices,
                'attr' => [
                    'class' => 'custom-select'
                ]
            ]);
        }
    }
}

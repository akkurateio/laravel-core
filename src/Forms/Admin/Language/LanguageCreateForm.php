<?php

namespace Akkurate\LaravelCore\Forms\Admin\Language;

use Kris\LaravelFormBuilder\Form;

class LanguageCreateForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('label', 'text', ['label' => __('Label')])
            ->add('locale', 'text', ['label' => __('Locale').' *', 'rules' => 'required'])
            ->add('locale_php', 'text', ['label' => __('Locale PHP').' *', 'rules' => 'required']);
    }
}

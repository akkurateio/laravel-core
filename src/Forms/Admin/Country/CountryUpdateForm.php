<?php

namespace Akkurate\LaravelCore\Forms\Admin\Country;

use Kris\LaravelFormBuilder\Form;

class CountryUpdateForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => __('Name').' *', 'rules' => 'required'])
            ->add('code', 'text', ['label' => __('Code').' *', 'rules' => 'required']);
    }
}

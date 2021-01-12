<?php

namespace Akkurate\LaravelCore\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class AddressesComponent extends FormField
{
    protected function getTemplate()
    {
        return 'back::fields.addresses';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
//        $options['fields'] = $this->getOptions()['fields'] ?? ['primary' => 'name'];
//        $options['object'] = $this->parent->getModel();
//        $options['options'] = [];
        return parent::render($options, $showLabel, $showField, $showError);
    }
}

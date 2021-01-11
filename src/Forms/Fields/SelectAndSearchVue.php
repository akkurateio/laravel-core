<?php

namespace Akkurate\LaravelCore\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class SelectAndSearchVue extends FormField
{
    protected function getTemplate()
    {
        return 'back::fields.selectandsearch-vue';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
//        $options['fields'] = $this->getOptions()['fields'] ?? ['primary' => 'name'];
        $options['object'] = $this->parent->getModel();
        $options['apiUrl'] = $this->getOptions()['apiUrl'];
        $options['options'] = [];
//        $options['configVue'] = [
//            'object' => $this->parent->getModel(),
//            'value' => $this->getOptions()['value'],
//            'package' => $this->getOptions()['package'],
//            'model' => $this->getOptions()['model'],
//            'label' => $this->getOptions()['label'],
//        ];

        return parent::render($options, $showLabel, $showField, $showError);
    }
}

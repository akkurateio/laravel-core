<?php

namespace Akkurate\LaravelCore\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class SelectVue extends FormField
{
    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'back::fields.select-vue';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['parent'] = $this->parent->getModel();


        $options['choices'] = $this->getOptions()['choices'] ?? '';
        $options['model'] = $this->getOptions()['model'] ?? null;
        $options['with'] = $this->getOptions()['with'] ?? null;
//        $options['include'] = implode(',', $options['with']);

        if (!empty($options['model'])) {
            $model = str_singular($options['model']);
            $options['entry'] = $options['parent']->$model ?? null;
        }

        return parent::render($options, $showLabel, $showField, $showError);
    }

}

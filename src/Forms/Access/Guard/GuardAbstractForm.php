<?php

namespace Akkurate\LaravelCore\Forms\Access\Guard;

use Kris\LaravelFormBuilder\Form;

class GuardAbstractForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => __('Nom')]);
    }
}

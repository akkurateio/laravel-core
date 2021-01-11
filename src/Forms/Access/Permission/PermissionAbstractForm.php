<?php

namespace Akkurate\LaravelCore\Forms\Access\Permission;

use Kris\LaravelFormBuilder\Form;

class PermissionAbstractForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => __('Nom')]);
    }
}

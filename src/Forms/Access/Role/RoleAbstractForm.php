<?php

namespace Akkurate\LaravelCore\Forms\Access\Role;

use Kris\LaravelFormBuilder\Form;

class RoleAbstractForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => __('Nom')]);
    }
}

<?php

namespace Akkurate\LaravelCore\Forms\Me\User;

use Kris\LaravelFormBuilder\Form;
use Spatie\Permission\Models\Role;

class UpdateForm extends Form
{
    public function buildForm()
    {
        $roles = config('laravel-me.roles');
        $choicesRoles = [];

        if (! empty($roles)) {
            foreach ($roles as $key => $role) {
                $existingRole = Role::where('name', $key)->first();

                if (! empty($existingRole)) {
                    $choicesRoles[$existingRole->id] = $role['name'];
                }
            }
        }

        $selectedRole = $this->model->roles()->first();

        $this
            ->add('role_id', 'select', [
                'label' => __('Rôle de l’utilisateur'),
                'wrapper' => [
                    'class' => 'form-group mb-4'
                ],
                'choices' => $choicesRoles,
                'selected' => ! empty($selectedRole) ? $selectedRole->id : null,
                'attr' => [
                    'class' => 'custom-select'
                ],
            ])
            ;
    }
}

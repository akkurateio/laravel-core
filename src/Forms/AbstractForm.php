<?php

namespace Akkurate\LaravelCore\Forms;

use Kris\LaravelFormBuilder\Form;

class AbstractForm extends Form
{
    public function addSelect($field, $selection, $label, $attr = [])
    {
        if (count($selection) == 0) {
            $attr['fields'] = null;
            $this->add($field, 'select', ['label' => $label, 'choices' => $this->getInstanceName($selection), 'empty_value' => __('Vous devez ajouter une entrée'), 'attr' => $attr]);
        } elseif (count($selection) == 1) {
            $attr['fields'] = null;
            $this->add($field, 'select', ['label' => $label, 'choices' => $this->getInstanceName($selection), 'empty_value' => 'Votre choix', 'attr' => $attr]);
        } elseif (count($selection) <= config('app.radio-limit')) {
            $this->add($field, 'choice', ['label' => $label, 'choices' => $this->getInstanceName($selection), 'expanded' => true, 'multiple' => false, 'choice_options' => ['wrapper' => ['class' => 'custom-control custom-radio'], 'attr' => ['class' => 'custom-control-input'], 'label_attr' => ['class' => 'custom-control-label']]]);
        } elseif (count($selection) > 10) {
            $this->add($field, 'selectandsearch', ['label' => $label, 'choices' => $selection, 'attr' => $attr, 'fields' => $attr['fields']]);
        } else {
            $attr['fields'] = null;
            $this->add($field, 'select', ['label' => $label, 'choices' => $this->getInstanceName($selection), 'empty_value' => 'Votre choix', 'attr' => $attr]);
        }
    }

    public function getInstanceName($items)
    {
        if (count($items)) {
            if (array_key_exists('fullname', $items->first()->toArray())) {
                $instanceName = $items->pluck('fullname', 'id')->toArray();
            } elseif (array_key_exists('lastname', $items->first()->toArray()) && array_key_exists('firstname', $items->first()->toArray())) {
                $instanceName = [];
                foreach ($items as $item) {
                    if ($item->status) {
                        $instanceName[$item->id] = $item->lastname . ' ' . $item->firstname . ' • ' . $item->account->name;
                    }
                }
                //                dd($instanceName);
            } elseif (array_key_exists('lastname', $items->first()->toArray())) {
                $instanceName = $items->pluck('lastname', 'id')->toArray();
            } elseif (array_key_exists('firstname', $items->first()->toArray())) {
                $instanceName = $items->pluck('firstname', 'id')->toArray();
            } elseif (array_key_exists('name', $items->first()->toArray())) {
                $instanceName = $items->pluck('name', 'id')->toArray();
            } elseif (array_key_exists('title', $items->first()->toArray())) {
                $instanceName = $items->pluck('title', 'id')->toArray();
            } elseif (array_key_exists('label', $items->first()->toArray())) {
                $instanceName = $items->pluck('label', 'id')->toArray();
            } elseif (array_key_exists('value', $items->first()->toArray())) {
                $instanceName = $items->pluck('value', 'id')->toArray();
            } elseif (array_key_exists('reference', $items->first()->toArray())) {
                $instanceName = $items->pluck('reference', 'id')->toArray();
            } else {
                $instanceName = [];
                foreach ($items as $item) {
                    $instanceName[] = $item;
                }
            }
        } else {
            $instanceName = [];
        }

        return $instanceName;
    }
}

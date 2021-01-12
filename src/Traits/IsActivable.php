<?php

namespace Akkurate\LaravelCore\Traits;

/**
 * Trait IsActivable
 */
trait IsActivable
{
    public function scopeActive($query)
    {
        return $query
            ->where('is_active', true);
    }

    public function isActive()
    {
        return $this->is_active;
    }

    public function activate()
    {
        return $this->update([
            'is_active' => true
        ]);
    }

    public function deactivate()
    {
        return $this->update([
            'is_active' => false
        ]);
    }

    public function toggle()
    {
        return $this->update([
            'is_active' => ! $this->is_active
        ]);
    }
}

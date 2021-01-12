<?php

namespace Akkurate\LaravelCore\Traits\Access;

/**
 * Trait HasAccess
 */
trait HasAccess
{
    public function agent()
    {
        return $this->can('manage tickets');
    }

    public function isAgent()
    {
        return $this->can('manage tickets');
    }

    public function superadmin()
    {
        return $this->hasRole('superadmin');
    }

    public function isSuperadmin()
    {
        return $this->hasRole('superadmin');
    }

    public function admin()
    {
        return $this->hasRole('admin');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}

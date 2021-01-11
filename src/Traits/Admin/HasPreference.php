<?php

namespace Akkurate\LaravelCore\Traits\Admin;

use Akkurate\LaravelCore\Models\Preference;

/**
 * Trait HasPreference
 */
trait HasPreference {

    public function preference()
    {
        return $this->morphOne(Preference::class, 'preferenceable');
    }

}

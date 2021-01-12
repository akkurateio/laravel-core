<?php

namespace Akkurate\LaravelCore\Observers\Admin;

use Akkurate\LaravelCore\Models\Language;
use Akkurate\LaravelCore\Models\User;

/**
 * Class UserObserver
 * @package Akkurate\LaravelCore\Observers
 */
class UserObserver
{
    /**
     * @param User $user
     */
    public function created(User $user)
    {
        $language = Language::where('is_default', true)->first();

        $user->preference()->create([
            'language_id' => $language->id,
        ]);
    }
}

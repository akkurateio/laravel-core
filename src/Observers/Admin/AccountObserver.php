<?php

namespace Akkurate\LaravelCore\Observers\Admin;

use Akkurate\LaravelCore\Models\Account;
use Akkurate\LaravelCore\Models\Language;

/**
 * Class AccountObserver
 * @package Akkurate\LaravelCore\Observers
 */
class AccountObserver
{
    /**
     * @param Account $account
     */
    public function created(Account $account)
    {
        $language = Language::where('is_default', true)->first();

        $account->preference()->create([
            'language_id' => $language->id,
        ]);
    }
}

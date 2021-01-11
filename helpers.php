<?php

if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (!function_exists('mail_styles')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function mail_styles($variable = null)
    {
        $path = 'mail.transactional.' . config('general.theme');
        if(!empty($variable)) {
            $path .= '.' . $variable;
        }
        return config($path);
    }
}

if (!function_exists('general_config')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function general_config($variable = null)
    {
        $path = 'general.' . config('general.theme');
        if(!empty($variable)) {
            $path .= '.' . $variable;
        }
        return config($path);
    }
}

if (!function_exists('generate_password')) {
    /**
     * Helper to generate a secure password.
     *
     * @param int $length
     * @return string
     */
    function generate_password($length = 10)
    {
        $random_string = str_shuffle('abcdefghjklmnopqrstuvwxyz_ABCDEFGHJKLMNOPQRSTUVWXYZ_234567890_@!$%^&!@$%^&');
        return substr($random_string, 0, $length);
    }
}

if (!function_exists('getDomain')) {
    /**
     * Helper to grab the domain name.
     *
     * @return mixed
     */
    function getDomain()
    {
        return parse_url(request()->root())['host'];
    }
}

if (!function_exists('currentAccount')) {
    function currentAccount()
    {

        if (!class_exists(\Akkurate\LaravelCore\Models\Account::class)) {
            return null;
        }

        $account = \Akkurate\LaravelCore\Models\Account::where('slug', request('uuid'))
            ->with(['preference'])
            ->first();

        if(empty($account)) {
            $account = \Akkurate\LaravelCore\Models\Account::where('slug', request('uuid') ?? auth()->user()->account->slug)
                ->with(['preference'])
                ->first();
        }

        return $account;
    }
}

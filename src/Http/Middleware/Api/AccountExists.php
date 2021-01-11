<?php

namespace Akkurate\LaravelCore\Http\Middleware\Api;

use Closure;

class AccountExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $account = \Akkurate\LaravelCore\Models\Account::where('slug', $request->uuid)->orWhere('uuid', $request->uuid)->first();
        if(empty($account)) {
            return response()->json([
                'error' => 'Invalid account'
            ], 400);
        }
        return $next($request);
    }
}

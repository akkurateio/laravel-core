<?php

namespace Akkurate\LaravelCore\Http\Middleware\Api;

use Closure;
use Illuminate\Support\Facades\Auth;

class AccountAdministrator
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
        $account = \App\Models\Account::where('slug', $request->uuid)->first();
        if (! Auth::user()->hasRole('superadmin')) {
            if ($account->id !== Auth::user()->account->id && ! Auth::user()->accounts->contains($account->id)) {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 403);
            }
        }

        return $next($request);
    }
}

<?php

namespace Akkurate\LaravelCore\Http\Middleware\Back;

use Closure;
use Illuminate\Support\Facades\Auth;

class Account
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $account = \App\Models\Account::where('slug', $request->uuid)->first();
        if (! $account) {
            return redirect(config('laravel-core.admin.route') . '/' . Auth::user()->account->slug);
        }
        if (! Auth::user()->hasRole('superadmin')) {
            if ($account->id !== Auth::user()->account->id && ! Auth::user()->accounts->contains($account->id)) {
                Auth::logout();

                return redirect('/login');
            }
        }

        return $next($request);
    }
}

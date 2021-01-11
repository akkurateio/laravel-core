<?php

namespace Akkurate\LaravelCore\Http\Middleware\Back;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->intended(config('laravel-core.admin.route') . '/' . Auth::user()->account->slug);
        }
        return $next($request);
    }
}

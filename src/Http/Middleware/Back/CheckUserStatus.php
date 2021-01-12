<?php

namespace Akkurate\LaravelCore\Http\Middleware\Back;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
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
        if (auth()->user()->is_active != 1) {
            Auth::logout();

            return redirect('/login');
        }

        return $next($request);
    }
}

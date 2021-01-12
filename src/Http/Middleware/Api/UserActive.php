<?php

namespace Akkurate\LaravelCore\Http\Middleware\Api;

use Closure;

class UserActive
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
            return response()->json([
                'error' => 'Invalid user'
            ], 400);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class LastSeen
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
        auth()->user()->updateLastSeen();
        return $next($request);
    }
}

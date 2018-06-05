<?php

namespace App\Http\Middleware;

use Closure;

class LastSeen {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (auth()->check()) {
			auth()->user()->updateLastSeen();
		}

		$log = new \App\User_log();
		$log->autoLog($request->url(), $request->ip(), $request->method());

		return $next($request);

	}
}
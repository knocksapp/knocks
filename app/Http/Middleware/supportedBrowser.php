<?php

namespace App\Http\Middleware;

use App\Assistant;
use Closure;

class supportedBrowser {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if ($request->method() != 'GET') {
			return $next($request);
		}
		$assistant = new Assistant();
		if ($assistant->isSupportedBrowser()) {
			return $next($request);
		} else {
			return redirect()->action('UserController@unsupportedBrowser');
		}

	}
}

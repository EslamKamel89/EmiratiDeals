<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdmin {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle( Request $request, Closure $next, $quard = null ): Response {
		if ( auth()->guard( $quard )->check() && auth()->user()->isadmin ) {
			return redirect()->route( 'admin.dashboard' );
		}
		return $next( $request );
	}
}

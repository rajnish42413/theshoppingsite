<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class Admin
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
		if(Auth::check() && Auth::user()->role_id == 1){
			 return $next($request);
		}else{
			return Redirect('/admin_login');
		}
        return $next($request);
    }
}

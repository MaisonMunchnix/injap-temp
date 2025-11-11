<?php

namespace App\Http\Middleware;

use Closure;
//use Illuminate\Support\Facades\Auth;
use Auth;
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
            return redirect('/user');
        }

      /*   if(Auth::guard($guard)->check() &&  Auth::user()->userType =='admin'){
            return redirect('admin');           
         }else
        if(Auth::guard($guard)->check() &&  Auth::user()->userType =='staff'){
            return redirect('staff');
         }else
         if(Auth::guard($guard)->check() &&  Auth::user()->userType =='user'){
            return redirect('user');
         } */

        return $next($request);
    }
}

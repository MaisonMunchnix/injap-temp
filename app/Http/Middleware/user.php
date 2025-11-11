<?php

namespace App\Http\Middleware;

use Closure;

class user
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
        if(auth()->check() &&  Auth::user()->userType =='staff'){
            return redirect('staff');           
         }
        if(auth()->check() &&  Auth::user()->userType =='tellers'){
            return redirect('tellers');
         }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class tellerMw
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
        if(auth()->check() &&  Auth::user()->userType =='user'){
           return redirect('user');
        }

        if(auth()->check() &&  Auth::user()->userType =='staff'){
            return redirect('staff');
        }

        $response = $next($request);

        $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma','no-cache');
        $response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');

        return $response;
    }
}

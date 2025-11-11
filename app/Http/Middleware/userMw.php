<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class userMw
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
        return $next($request)
            ->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache')
            ->header('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
    }
}

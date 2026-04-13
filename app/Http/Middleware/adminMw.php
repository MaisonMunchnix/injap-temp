<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class adminMw
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
        if(auth()->check() &&  Auth::user()->userType =='tellers'){
            return redirect('tellers');
         }
        if(auth()->check() &&  Auth::user()->userType =='user'){
           return redirect('user');
        }
        // Only allow staff and approver users to access admin routes
        $allowedUserTypes = ['staff', 'paymentApprover', 'productApprover', 'applicationApprover'];
        if(auth()->check() && !in_array(Auth::user()->userType, $allowedUserTypes)){
            abort(403, 'Unauthorized access.');
        }

        if (auth()->check() && Auth::user()->userType === 'staff' && Auth::user()->admin_scope === 'instructors_only') {
            if (
                !$request->is('staff/instructors*')
                && !$request->is('staff/courses*')
                && !$request->is('staff/enrollments*')
                && !$request->is('staff/materials*')
            ) {
                if ($request->is('staff')) {
                    return redirect('staff/instructors');
                }

                abort(403, 'Unauthorized access.');
            }
        }

        $response = $next($request);
        $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma','no-cache');
        $response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
        return $response;
    }
}

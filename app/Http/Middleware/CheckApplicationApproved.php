<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckApplicationApproved
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
        // Only check for regular users, not admin/staff
        if (Auth::check() && Auth::user()->userType === 'user') {
            // Check if user is approved
            if (!Auth::user()->is_application_approved && Auth::user()->status != 1) {
                Auth::logout();
                return redirect('/login')->with('error', 'Your account is pending admin approval. Please try again later.');
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CanManageInstructors
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
        if (!auth()->check() || !Auth::user()->can_manage_instructors) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}

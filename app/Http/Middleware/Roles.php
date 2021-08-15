<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string ...$allowedRoles
     * @return mixed
     */
    public function handle(Request $request, Closure $next , string ...$allowedRoles): mixed
    {
        if(!in_array(auth()->user()->role , $allowedRoles , true))
            abort(403 , 'Unauthorized');
        return $next($request);
    }
}

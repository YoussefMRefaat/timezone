<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Verified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(! auth()->user()->email_verified_at)
            abort(403 , 'Email is not verified');
        return $next($request);
    }
}

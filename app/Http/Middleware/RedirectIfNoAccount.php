<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNoAccount
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
        dd($request);
        return $next($request);
    }
}

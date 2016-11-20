<?php


namespace App\Http\Middleware;

use Closure, Auth;


class RequireAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::guest() || !Auth::user()->hasRole('ADMIN'))
        {
            abort(403, 'Access Forbidden');
        }
        return $next($request);
    }
}
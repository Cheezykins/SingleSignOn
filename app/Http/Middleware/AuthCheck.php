<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthCheck
{
    public function handle($request, Closure $next)
    {
        $token = \Cookie::get('cheezyssotoken');
        try {
            JWTAuth::setToken($token)->authenticate();
        } catch (\Exception $e) {
            return response()->redirectTo('login');
        }
        return $next($request);
    }
}
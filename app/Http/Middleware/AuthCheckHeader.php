<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthCheckHeader
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('x-cheezy-sso-token');
        if ($token === null) {
            return $this->bad();
        }
        try {
            JWTAuth::setToken($token)->authenticate();
        } catch (\Exception $e) {
            return $this->bad();
        }
        return $this->good();
    }

    protected function bad()
    {
        return response('', 401);
    }

    protected function good()
    {
        return response();
    }
}
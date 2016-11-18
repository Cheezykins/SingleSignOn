<?php


namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class AuthCheckHeader
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('x-cheezy-sso-token');
	Log::info($token . ' recieved from header');
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
        return abort(401, 'Authentication Required');
    }

    protected function good()
    {
        return abort(200, 'OK');
    }
}

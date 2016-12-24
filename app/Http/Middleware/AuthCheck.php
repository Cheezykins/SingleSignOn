<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        $token = \Cookie::get('cheezyssotoken');
        try {
            $user = JWTAuth::setToken($token)->authenticate();
            if ($user->must_change_pass && $request->route()->getName() != 'password.change' && $request->route()->getName() != 'password.postchange') {
                $request->session()->flash('message', 'Your account has been marked for a password change');
                return response()->redirectToRoute('password.change');
            }
        } catch (\Exception $e) {
            return response()->redirectTo('login');
        }
        return $next($request);
    }
}
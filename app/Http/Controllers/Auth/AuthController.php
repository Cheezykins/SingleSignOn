<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        return $this->login($request);
    }

    protected function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        try {
            $token = JWTAuth::attempt($credentials);
        } catch (JWTException $e) {
            return redirect()->back()->withInput($request->only('username'))->withErrors([
                'username' => $e->getMessage()
            ]);
        }

        if ($token) {
            Cookie::queue(Cookie::forever('cheezyssotoken', $token, '/', env('COOKIE_DOMAIN', null)));
            return response()->redirectTo('/');
        }

        return redirect()->back()
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => 'Your credentials were not recognised',
            ]);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        Cookie::queue(Cookie::forget('cheezyssotoken', '/', env('COOKIE_DOMAIN', null)));
        return response()->redirectGuest('login');
    }
}

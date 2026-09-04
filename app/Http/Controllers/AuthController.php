<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function login_check(Request $request)
    {
        $user = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::attempt($user)) {
            return redirect()->route('dashboard.index')->with('Welcome back' . Auth::user()->name);
        } else {
            return back()->with('error','The provided credentials do not match our records');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

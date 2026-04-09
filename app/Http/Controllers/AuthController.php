<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard based on role
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Redirect to the respective dashboard based on role.
     */
    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->intended('/dashboard/admin');
        } elseif ($user->role === 'petugas') {
            return redirect()->intended('/dashboard/petugas');
        } elseif ($user->role === 'owner') {
            return redirect()->intended('/dashboard/owner');
        }

        return redirect('/');
    }}

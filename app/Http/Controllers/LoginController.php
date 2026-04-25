<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login page.
     * Route: GET /login (name: login)
     */
    public function login(): View
    {
        return view('auth.login');
    }

    /**
     * Store a newly registered user account.
     * Route: POST /login (name: login.authenticate)
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'password' => 'required|string',
            'email' => 'required|string|max:100',
        ]);

        // Attempt to authenticate user
        if (Auth::attempt($credentials)) {
            // regenerate the session to prevent fixation attacks
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'You are now logged in');
        }

        // if auth fails, redirect with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match',
        ])->onlyInput('email');

    }

    /**
     * Display the logout page.
     * Route: POST /logout (name: logout)
     *
     * @return Redirect
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

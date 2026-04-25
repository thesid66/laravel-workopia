<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegisterController extends Controller
{
    /**
     * Display the registration page.
     * Route: GET /register (name: register)
     *
     * @return View
     */
    public function register(): View
    {
        return view('auth.register');
    }

    /**
     * Store a newly registered user account.
     * Route: POST /register (name: register.store)
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse 
    {
        $validatedData = $request->validate([
            'name'=>'required|string|max:100',
            'password'=>'required|string|max:8|confirmed',
            'email'=>'required|string|max:100|unique:users',
        ]);

        // Hash the password
        $validatedData['password']=Hash::make($validatedData['password']);

        // Create user
        $user= User::create($validatedData);

        return redirect()->route('login')->with('success','You are registerd and can login');
    }
}

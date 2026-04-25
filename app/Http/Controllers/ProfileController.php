<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Update the logged in user's profile information.
     * Route: PUT /profile (name: profile.update)
     */
    public function update(Request $request): RedirectResponse
    {
        // Get the login user
        $user = Auth::user();

        // Validate the data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        // Handle avatar
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/'.basename($user->avatar));
            }

            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar'] = Storage::url($avatarPath);

        }

        // Update user info
        $user->update($validatedData);

        return back()->with('success', 'Profile info updated');
    }
}

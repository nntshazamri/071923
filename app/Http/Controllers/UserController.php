<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
        return view('user.editprofile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validate profile fields
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $user->userID . ',userID',
            'phoneNo' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phoneNo = $request->phoneNo;

        // If password is provided, hash and update it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('userprofile')->with('success', 'Profile updated successfully.');
    }
}

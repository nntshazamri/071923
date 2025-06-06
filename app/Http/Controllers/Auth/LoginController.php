<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        \Log::info('Attempting login for email: ' . $request->email);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
    \Log::info('Login successful! Redirecting to correct dashboard.');

    // Check role of user
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admindashboard');
    } else {
        return redirect()->route('userprofile');
    }
}

        \Log::warning('Login failed for email: ' . $request->email);
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout()
    {
        Auth::logout(); // Logs the user out
        return redirect('/');
    }
}

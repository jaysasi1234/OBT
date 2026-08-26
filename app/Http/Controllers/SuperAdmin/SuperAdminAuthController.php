<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.superadmin-login');
    }

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::user();

        // Update online status
        $user->update([
            'is_online'     => true,
            'last_activity' => now(),
            'last_login_at' => now(),
        ]);

        if ($user->role !== 'dean') {

            Auth::logout();

            return back()->withErrors([
                'email' => 'Unauthorized access.',
            ]);
        }

        return redirect()->route('superadmin.dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
}

public function logout(Request $request)
{
    if (Auth::check()) {

    Auth::user()->update([
        'is_online'     => false,
        'last_activity' => now(),
    ]);

    }

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('superadmin.login');
}
}
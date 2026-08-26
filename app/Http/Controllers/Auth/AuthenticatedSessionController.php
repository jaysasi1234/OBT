<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();
    $user = Auth::user();

    $user->update([
        'is_online'      => true,
        'last_activity'  => now(),
        'last_login_at'  => now(),
    ]);

    if ($user->isDean()) {
        return redirect()->route('super-admin.dashboard');
    }

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->isCadet()) {
        return redirect()->route('dashboard');
    }

    Auth::logout();

    return redirect('/')
        ->withErrors([
            'email' => 'Unauthorized account.',
        ]);
}

    /**
     * Destroy an authenticated session.
     */
public function destroy(Request $request): RedirectResponse
{
    if (Auth::check()) {

        Auth::user()->update([
            'is_online' => false,
        ]);

    }

    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
}
}
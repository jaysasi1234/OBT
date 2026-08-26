<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use PragmaRX\Google2FA\Google2FA;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\SvgWriter;

class AdminAuthController extends Controller
{
    /**
     * Show Admin Login
     */
    public function showLoginForm(): View
    {
        return view('auth.admin-login');
    }

    /**
     * First authentication factor:
     * Email + Password
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check Credentials
        |--------------------------------------------------------------------------
        */

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'Invalid email or password.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Check Admin Role
        |--------------------------------------------------------------------------
        */

        if (!$user->isAdmin()) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'You are not authorized as an admin.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Check if 2FA is already configured
        |--------------------------------------------------------------------------
        */

        if (!empty($user->two_factor_secret)) {

            /*
            |--------------------------------------------------------------------------
            | 2FA Required
            |--------------------------------------------------------------------------
            */

            $request->session()->put('admin_2fa_pending', true);
            $request->session()->put('admin_2fa_user_id', $user->id);

            /*
            |--------------------------------------------------------------------------
            | Log the user out temporarily.
            |
            | The password was correct, but the Admin must still
            | complete the second authentication factor.
            |--------------------------------------------------------------------------
            */

            Auth::logout();

            return redirect()->route('admin.two-factor.challenge');
        }

        /*
        |--------------------------------------------------------------------------
        | First Login / 2FA Not Configured
        |--------------------------------------------------------------------------
        */

        $request->session()->put('admin_2fa_setup_user_id', $user->id);

        Auth::logout();

        return redirect()->route('admin.two-factor.setup');
    }

    /**
     * Show first-time 2FA setup.
     */
    public function showTwoFactorSetup(Request $request): View|RedirectResponse
    {
        $userId = $request->session()->get('admin_2fa_setup_user_id');

        if (!$userId) {
            return redirect()->route('admin.login');
        }

        $user = \App\Models\User::find($userId);

        if (!$user || !$user->isAdmin()) {
            $request->session()->forget('admin_2fa_setup_user_id');

            return redirect()->route('admin.login');
        }

        /*
        |--------------------------------------------------------------------------
        | Generate Secret
        |--------------------------------------------------------------------------
        */

        if (empty($user->two_factor_secret)) {

            $google2fa = new Google2FA();

            $secret = $google2fa->generateSecretKey();

            $user->forceFill([
                'two_factor_secret' => encrypt($secret),
            ])->save();
        }

        /*
        |--------------------------------------------------------------------------
        | Get Secret
        |--------------------------------------------------------------------------
        */

        $secret = decrypt($user->two_factor_secret);

        /*
        |--------------------------------------------------------------------------
        | Generate QR Code
        |--------------------------------------------------------------------------
        */

        $google2fa = new Google2FA();

        $otpauthUrl = $google2fa->getQRCodeUrl(
            'On Board Training Report System',
            $user->email,
            $secret
        );

        $builder = new Builder(
            writer: new SvgWriter(),
            writerOptions: [],
            validateResult: false,
            data: $otpauthUrl,
            encoding: new Encoding('UTF-8'),
            size: 220,
            margin: 10,
        );

        $qrCode = $builder->build();

        $qrCodeUrl = $qrCode->getDataUri();

        return view('auth.admin-two-factor-setup', [
            'user' => $user,
            'secret' => $secret,
            'qrCodeUrl' => $qrCodeUrl,
        ]);
    }

    /**
     * Confirm first-time 2FA setup.
     */
    public function confirmTwoFactorSetup(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => [
                'required',
                'digits:6',
            ],
        ]);

        $userId = $request->session()->get('admin_2fa_setup_user_id');

        if (!$userId) {
            return redirect()->route('admin.login');
        }

        $user = \App\Models\User::find($userId);

        if (!$user || !$user->isAdmin()) {
            $request->session()->forget('admin_2fa_setup_user_id');

            return redirect()->route('admin.login');
        }

        if (empty($user->two_factor_secret)) {
            return back()->withErrors([
                'code' => 'Two-factor authentication has not been initialized.',
            ]);
        }

        $secret = decrypt($user->two_factor_secret);

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(
            $secret,
            $request->code
        );

        if (!$valid) {
            return back()->withErrors([
                'code' => 'Invalid authentication code. Please try again.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Generate Recovery Codes
        |--------------------------------------------------------------------------
        */

        $recoveryCodes = collect(range(1, 8))
            ->map(fn () => strtoupper(bin2hex(random_bytes(5))))
            ->values()
            ->toArray();

        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(
                json_encode($recoveryCodes)
            ),
            'two_factor_confirmed_at' => now(),
        ])->save();

        /*
        |--------------------------------------------------------------------------
        | Complete Authentication
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        Auth::login($user);

        $request->session()->forget([
            'admin_2fa_pending',
            'admin_2fa_user_id',
        ]);

        $user->update([
            'is_online' => true,
            'last_activity' => now(),
            'last_login_at' => now(),
        ]);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Show 2FA challenge.
     */
    public function showTwoFactorChallenge(Request $request): View|RedirectResponse
    {
        if (!$request->session()->get('admin_2fa_pending')) {
            return redirect()->route('admin.login');
        }

        return view('auth.two-factor-challenge');
    }

    /**
     * Verify 2FA code.
     */
    public function verifyTwoFactor(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => [
                'required',
                'digits:6',
            ],
        ]);

        if (!$request->session()->get('admin_2fa_pending')) {
            return redirect()->route('admin.login');
        }

        $userId = $request->session()->get('admin_2fa_user_id');

        $user = \App\Models\User::find($userId);

        if (!$user || !$user->isAdmin()) {

            $request->session()->forget([
                'admin_2fa_pending',
                'admin_2fa_user_id',
            ]);

            return redirect()->route('admin.login');
        }

        if (empty($user->two_factor_secret)) {

            $request->session()->forget([
                'admin_2fa_pending',
                'admin_2fa_user_id',
            ]);

            return redirect()->route('admin.login');
        }

        $secret = decrypt($user->two_factor_secret);

        $google2fa = new Google2FA();

        /*
        |--------------------------------------------------------------------------
        | Verify Authenticator Code
        |--------------------------------------------------------------------------
        */

        if (!$google2fa->verifyKey(
            $secret,
            $request->code,
            2
        )) {
            return back()->withErrors([
                'code' => 'Invalid authentication code.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Second Factor Successful
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        $request->session()->forget([
            'admin_2fa_pending',
            'admin_2fa_user_id',
        ]);

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Update Online / Login Information
        |--------------------------------------------------------------------------
        */

        $user->update([
            'is_online' => true,
            'last_activity' => now(),
            'last_login_at' => now(),
        ]);

        return redirect()->intended(
            route('admin.dashboard')
        );
    }

    /**
     * Logout
     */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {

            Auth::user()->update([
                'is_online' => false,
                'last_activity' => now(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
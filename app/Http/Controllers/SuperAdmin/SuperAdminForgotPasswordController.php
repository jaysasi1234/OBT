<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SuperAdminForgotPasswordController extends Controller
{
    /**
     * Show forgot password form.
     */
    public function showLinkRequestForm()
    {
        return view('superadmin.auth.forgot-password');
    }

    /**
     * Send password reset link.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Make sure the account is a Super Admin / Dean
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $request->email)->first();

        if (!$user || !in_array($user->role, ['superadmin', 'dean'])) {

            return back()
                ->withErrors([
                    'email' => 'This email is not registered as a Super Admin account.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Send Reset Link
        |--------------------------------------------------------------------------
        */

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {

            return back()->with(
                'status',
                'We have emailed your password reset link!'
            );
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }

    /**
     * Show reset password form.
     */
    public function showResetForm(Request $request, $token)
    {
        return view('superadmin.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Make sure this is a Super Admin / Dean account
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $request->email)->first();

        if (!$user || !in_array($user->role, ['superadmin', 'dean'])) {

            return back()
                ->withErrors([
                    'email' => 'This account is not authorized to use the Super Admin password reset.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Reset Password
        |--------------------------------------------------------------------------
        */

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function (User $user) use ($request) {

                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                /*
                |--------------------------------------------------------------------------
                | Make sure the user is logged out after password reset
                |--------------------------------------------------------------------------
                */

                Auth::logout();
            }
        );

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        if ($status === Password::PASSWORD_RESET) {

            return redirect()
                ->route('superadmin.login')
                ->with(
                    'success',
                    'Your password has been reset successfully! You can now log in.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | FAILED
        |--------------------------------------------------------------------------
        */

        return back()
            ->withInput(
                $request->only('email')
            )
            ->withErrors([
                'email' => __($status),
            ]);
    }
}
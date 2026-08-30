<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Forgot Password Page
    |--------------------------------------------------------------------------
    */

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }


    /*
    |--------------------------------------------------------------------------
    | Send Reset Link
    |--------------------------------------------------------------------------
    */

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email'
            ],
        ]);


        $user = User::where(
            'email',
            $request->email
        )
        ->whereIn('role', [
            'admin',
            'dean'
        ])
        ->first();


        if (!$user) {

            return back()
                ->withInput(
                    $request->only('email')
                )
                ->withErrors([
                    'email' =>
                        'If an account with that email address exists, password reset instructions have been sent to your email.'
                ]);
        }


        $status = Password::sendResetLink([
            'email' => $user->email
        ]);


        if ($status === Password::RESET_LINK_SENT) {

            return back()->with(
                'status',
                'Password reset instructions have been sent to your email.'
            );
        }


        return back()
            ->withInput(
                $request->only('email')
            )
            ->withErrors([
                'email' => __($status)
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Reset Password Page
    |--------------------------------------------------------------------------
    */

    public function showResetForm(
        Request $request,
        string $token
    ) {

        return view(
            'auth.reset-password',
            [
                'token' => $token,

                'email' =>
                    $request->email,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    */

    public function reset(Request $request)
    {
        $request->validate([

            'token' => [
                'required'
            ],

            'email' => [
                'required',
                'email'
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8'
            ],
        ]);


        $user = User::where(
            'email',
            $request->email
        )
        ->whereIn('role', [
            'admin',
            'dean'
        ])
        ->first();


        if (!$user) {

            return back()->withErrors([
                'email' =>
                    'This account is not authorized for administrator password reset.'
            ]);
        }


        $status = Password::reset(

            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function ($user) use ($request) {

                $user->forceFill([

                    'password' =>
                        Hash::make(
                            $request->password
                        ),

                    'remember_token' =>
                        Str::random(60),

                ])->save();
            }
        );


        if ($status === Password::PASSWORD_RESET) {

            return redirect()
                ->route('admin.login')
                ->with(
                    'status',
                    'Your password has been reset successfully. You can now sign in using your new password.'
                );
        }


        return back()
            ->withInput(
                $request->only('email')
            )
            ->withErrors([
                'email' => __($status)
            ]);
    }
}
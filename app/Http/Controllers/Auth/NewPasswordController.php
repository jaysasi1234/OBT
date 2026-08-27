<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', [
            'request' => $request
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | RESET PASSWORD
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

                event(new PasswordReset($user));
            }
        );

/*
|--------------------------------------------------------------------------
| PASSWORD RESET SUCCESS
|--------------------------------------------------------------------------
*/

if ($status === Password::PASSWORD_RESET) {

    /*
    |--------------------------------------------------------------------------
    | Find the user whose password was just reset
    |--------------------------------------------------------------------------
    */

    $user = User::where('email', $request->email)->first();

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    |
    | Super Admin must always return to:
    | superadmin.login
    |
    */

    if ($user && $user->role === 'superadmin') {

        return redirect()
            ->route('superadmin.login')
            ->with(
                'success',
                'Your password has been set successfully. You can now log in.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DEAN
    |--------------------------------------------------------------------------
    */

    if ($user && $user->role === 'dean') {

        return redirect()
            ->route('superadmin.login')
            ->with(
                'success',
                'Your password has been set successfully. You can now log in.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    if ($user && $user->role === 'admin') {

        return redirect()
            ->route('admin.login')
            ->with(
                'success',
                'Your password has been set successfully. You can now log in.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | OTHER ACCOUNTS
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('login')
        ->with(
            'status',
            __($status)
        );
}

        /*
        |--------------------------------------------------------------------------
        | PASSWORD RESET FAILED
        |--------------------------------------------------------------------------
        */

        return back()
            ->withInput(
                $request->only('email')
            )
            ->withErrors([
                'email' => __($status)
            ]);
    }
}
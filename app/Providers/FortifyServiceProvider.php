<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Fortify Login
        |--------------------------------------------------------------------------
        */

        Fortify::authenticateUsing(function (Request $request) {

            $user = \App\Models\User::where(
                'email',
                $request->email
            )->first();

            if (
                $user &&
                \Illuminate\Support\Facades\Hash::check(
                    $request->password,
                    $user->password
                )
            ) {
                return $user;
            }

            return null;
        });

        /*
        |--------------------------------------------------------------------------
        | Two-Factor Challenge View
        |--------------------------------------------------------------------------
        */

        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });

        /*
        |--------------------------------------------------------------------------
        | Rate Limiting
        |--------------------------------------------------------------------------
        */

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by(
                $email . '|' . $request->ip()
            );
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->session()->get('login.id') .
                '|' .
                $request->ip()
            );
        });
    }
}
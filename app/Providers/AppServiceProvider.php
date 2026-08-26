<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Custom Password Reset URL
        |--------------------------------------------------------------------------
        */

        ResetPassword::createUrlUsing(
            function ($notifiable, $token) {

                $email = $notifiable->getEmailForPasswordReset();

                /*
                |--------------------------------------------------------------------------
                | Admin / Dean
                |--------------------------------------------------------------------------
                */

                if (in_array($notifiable->role, ['admin', 'dean'])) {

                    return url(
                        route(
                            'admin.password.reset',
                            [
                                'token' => $token,
                                'email' => $email,
                            ],
                            false
                        )
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Cadet
                |--------------------------------------------------------------------------
                */

                if ($notifiable->role === 'cadet') {

                    return url(
                        route(
                            'password.reset',
                            [
                                'token' => $token,
                                'email' => $email,
                            ],
                            false
                        )
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Fallback
                |--------------------------------------------------------------------------
                */

                return url(
                    route(
                        'password.reset',
                        [
                            'token' => $token,
                            'email' => $email,
                        ],
                        false
                    )
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Update Last Login
        |--------------------------------------------------------------------------
        */

        Event::listen(
            Login::class,
            function ($event) {

                $event->user->update([
                    'last_login_at' => now()
                ]);
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Admin Layout
        |--------------------------------------------------------------------------
        */

        View::composer(
            'layouts.admin',
            function ($view) {

                if (Auth::check()) {

                    $user = Auth::user();

                    $view->with([

                        'notifications' =>
                            $user
                                ->unreadNotifications()
                                ->get(),

                        'unreadCount' =>
                            $user
                                ->unreadNotifications()
                                ->count(),

                    ]);
                }
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Cadet Layout
        |--------------------------------------------------------------------------
        */

        View::composer(
            'layouts.cadet',
            function ($view) {

                if (Auth::check()) {

                    $view->with(
                        'unreadNotificationsCount',

                        Auth::user()
                            ->unreadNotifications()
                            ->count()
                    );
                }
            }
        );
    }
}
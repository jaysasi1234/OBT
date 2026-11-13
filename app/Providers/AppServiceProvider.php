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
| Admin Layout Notifications
|--------------------------------------------------------------------------
*/

View::composer('layouts.admin', function ($view) {

    $user = Auth::user();

    $notifications = collect();
    $unreadCount = 0;

    if ($user && in_array($user->role, ['admin', 'dean'])) {

        $notifications = $user->notifications()
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = $user->unreadNotifications()->count();
    }

    $view->with([
        'notifications' => $notifications,
        'unreadCount' => $unreadCount,
    ]);

});

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

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            $user = Auth::user();

            $user->forceFill([
                'last_activity' => now(),
                'is_online' => true,
            ])->save();

        }

        return $next($request);
    }
}
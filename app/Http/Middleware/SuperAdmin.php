<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class SuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        
        $user = Auth::user();

        if (!$user || $user->role !== 'dean') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
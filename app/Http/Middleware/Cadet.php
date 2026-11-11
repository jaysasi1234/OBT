<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cadet
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== 'cadet') {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}

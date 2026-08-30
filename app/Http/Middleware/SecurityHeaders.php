<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent MIME-type sniffing
        $response->headers->set(
            'X-Content-Type-Options',
            'nosniff'
        );

        // Prevent your pages from being embedded by other origins
        $response->headers->set(
            'X-Frame-Options',
            'SAMEORIGIN'
        );

        // Control how much referrer information is sent
        $response->headers->set(
            'Referrer-Policy',
            'strict-origin-when-cross-origin'
        );

        // Restrict browser features that your application does not need
        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), geolocation=(self)'
        );

        // Enable HSTS ONLY when the application is running over HTTPS.
        // Do not enable this on localhost/Laragon.
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        return $response;
    }
}
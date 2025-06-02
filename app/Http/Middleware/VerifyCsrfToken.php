<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log; // Optionally for logging

class VerifyCsrfToken
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*', // Exclude all API routes from CSRF verification
        'webhook/*', // Exclude all webhook routes from CSRF verification
        
    ];
    

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // This is the default CSRF verification logic
        if ($this->tokensMatch($request)) {
            return $next($request);
        }

        // Optionally log the CSRF verification failure
        Log::warning('CSRF Token Mismatch', ['request' => $request->all()]);

        // If the CSRF token doesn't match, throw an exception
        abort(419, 'Page Expired');  // 419 is the status code for CSRF token mismatch
    }

    /**
     * Check if the CSRF token in the request matches the session token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch(Request $request)
    {
        // Check if the request has the correct CSRF token
        $token = $request->header('X-CSRF-TOKEN') ?: $request->input('_token');
        return hash_equals($token, $request->session()->token());
    }
}


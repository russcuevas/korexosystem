<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfVerifiedReference
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('verified_reference')) {
            // Check if 'intended_url' exists in session
            $redirectUrl = session()->get('intended_url', route('home.page'));

            // Forget it after redirect so it doesn't persist
            session()->forget('intended_url');

            return redirect($redirectUrl);
        }

        return $next($request);
    }
}

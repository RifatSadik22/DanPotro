<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                           ->with('error', 'Please login to access this page.');
        }

        // Check if authenticated user is admin
        if (!Auth::user()->isAdmin()) {
            // Log unauthorized access attempt
            \Log::warning('Unauthorized admin access attempt', [
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'requested_url' => $request->fullUrl(),
                'timestamp' => now()
            ]);

            return redirect()->route('home')
                           ->with('error', 'Access denied. Administrator privileges required.');
        }

        // Log admin access for security audit
        \Log::info('Admin access granted', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'ip_address' => $request->ip(),
            'requested_url' => $request->fullUrl(),
            'timestamp' => now()
        ]);

        return $next($request);
    }
}
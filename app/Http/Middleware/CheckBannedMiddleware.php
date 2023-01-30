<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBannedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return string
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasPermission('banned')) {

            // request API
            if ($request->expectsJson()) {
                $request->user()->tokens()->delete();
                return response()->json([
                    'message' => __('auth.Your account has been suspended')
                ], 401);

            } else {
                // request web
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withInput()->withErrors([__('auth.Your account has been suspended')]);
            }

        }

        return $next($request);
    }
}

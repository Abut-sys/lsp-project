<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect(RouteServiceProvider::ADMIN_DASHBOARD)
                : redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}

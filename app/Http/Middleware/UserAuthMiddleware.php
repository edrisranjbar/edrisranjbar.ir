<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (!Auth::guard('user')->check()) {
            return redirect()->route('user.login');
        }

        return $next($request);
    }
}

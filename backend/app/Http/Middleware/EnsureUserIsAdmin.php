<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is an Admin
        if (!$request->user() || !($request->user() instanceof Admin)) {
            return response()->json([
                'success' => false,
                'message' => 'شما دسترسی لازم برای انجام این عملیات را ندارید.'
            ], 403);
        }

        // Check if the admin is active
        if (!$request->user()->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'حساب کاربری شما غیرفعال شده است. لطفا با پشتیبانی تماس بگیرید.'
            ], 403);
        }

        return $next($request);
    }
}

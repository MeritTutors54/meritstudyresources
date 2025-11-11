<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check()) {
            return to_route('admin.dashboard');
        }

//        if (Auth::guard('web')->check()) {
//            return to_route('web.dashboard');
//        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccessMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole(['admin', 'super-admin']))  {
            return $next($request);
        } else{
            return redirect()->back();
        }
    }
}

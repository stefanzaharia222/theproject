<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            // Check if the user is active
            $user = User::where('email', $request->input('email'))->first();

            if ($user && $user->status == 1) {
                return redirect(RouteServiceProvider::HOME);
            } else {
                Auth::logout(); // Log out the user if status is not active
                return redirect()->back()->with('failed', 'User is not active');
            }
        }

        return $next($request);
    }
}

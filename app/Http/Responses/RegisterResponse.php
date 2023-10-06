<?php

namespace App\Http\Responses;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse
{
    public function toResponse(Request $request) {
        $routeDefined = (Auth::user()->hasRole('super-admin')) ? route('super-admin') : route('client-admin');

        return redirect($routeDefined);
    }
}
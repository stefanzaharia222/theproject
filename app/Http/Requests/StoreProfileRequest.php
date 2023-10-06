<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Rules\Password;

class StoreProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email," . $this->route()->user->id,
            'phone' => "required|max:255|unique:users,phone," . $this->route()->user->id,
            'password' => ['nullable','string', new Password, 'confirmed'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->user()->roles->pluck('name')->contains('super-admin');
    }
}

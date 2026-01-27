<?php

namespace App\Http\Requests\Frontend\ResetPassword;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'password-again' => 'required|string|min:8|same:password',
        ];
    }
}
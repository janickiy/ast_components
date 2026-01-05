<?php

namespace App\Http\Requests\Frontend\Invite;

use Illuminate\Foundation\Http\FormRequest;

class SendRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'company' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'platform' => 'required',
            'numb' => 'required',
        ];
    }
}
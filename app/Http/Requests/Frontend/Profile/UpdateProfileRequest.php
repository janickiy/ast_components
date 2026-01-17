<?php

namespace App\Http\Requests\Frontend\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('customer')->check();
    }

    public function rules(): array
    {
        $customer = Auth::guard('customer')->user();

        return [
            'phone' => [
                'required',
                'string',
                'max:32',
                Rule::unique('customers', 'phone')->ignore($customer->id),
            ],

            'name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                Rule::unique('customers', 'email')->ignore($customer->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Введите номер телефона.',
            'phone.string'   => 'Номер телефона должен быть строкой.',
            'phone.max'      => 'Номер телефона не должен превышать :max символов.',
            'phone.unique'   => 'Этот номер телефона уже используется.',

            'name.string' => 'Имя должно быть строкой.',
            'name.max'    => 'Имя не должно превышать :max символов.',

            'password.string'    => 'Пароль должен быть строкой.',
            'password.min'       => 'Пароль должен быть не короче :min символов.',
            'password.confirmed' => 'Пароль и подтверждение не совпадают.',
        ];
    }

    public function attributes(): array
    {
        return [
            'phone'                 => 'номер телефона',
            'name'                  => 'имя',
            'password'              => 'пароль',
            'password_confirmation' => 'подтверждение пароля',
        ];
    }
}

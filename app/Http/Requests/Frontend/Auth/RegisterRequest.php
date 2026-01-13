<?php

namespace App\Http\Requests\Frontend\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email|max:255',
            'password' => 'required|string|min:8',
            'password-again' => 'required|string|min:8|same:password',
            'agreement' => 'accepted',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Введите ваше имя',
            'name.max' => 'Имя не должно превышать 255 символов',
            'email.required' => 'Введите email',
            'email.email' => 'Введите корректный email',
            'email.unique' => 'Этот email уже зарегистрирован',
            'password.required' => 'Введите пароль',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password-again.same' => 'Пароли не совпадают',
            'password-again.required' => 'Введите повторно пароль',
            'password-again.min' => 'Пароль должен содержать минимум 8 символов',
            'agreement.accepted' => 'Необходимо принять политику конфиденциальности',
        ];
    }
}

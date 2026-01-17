<?php

namespace App\Http\Requests\Frontend\Profile;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $customer = Auth::guard('customer')->user();

        /** @var \App\Models\Company $company */
        $company = Company::query()
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'inn' => [
                'required',
                'string',
                'max:32',
                Rule::unique('company', 'inn')->ignore($company?->id),
            ],

            'contact_person' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:32',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('company', 'email')->ignore($company?->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название компании.',
            'name.string'   => 'Название компании должно быть строкой.',
            'name.max'      => 'Название компании не должно превышать :max символов.',

            'inn.required' => 'Введите ИНН.',
            'inn.string'   => 'ИНН должен быть строкой.',
            'inn.max'      => 'ИНН не должен превышать :max символов.',
            'inn.unique'   => 'Компания с таким ИНН уже существует.',

            'contact_person.required' => 'Введите контактное лицо.',
            'contact_person.string'   => 'Контактное лицо должно быть строкой.',
            'contact_person.max'      => 'Контактное лицо не должно превышать :max символов.',

            'phone.required' => 'Введите номер телефона.',
            'phone.string'   => 'Номер телефона должен быть строкой.',
            'phone.max'      => 'Номер телефона не должен превышать :max символов.',

            'email.required' => 'Введите email.',
            'email.email'    => 'Введите корректный email адрес.',
            'email.max'      => 'Email не должен превышать :max символов.',
            'email.unique'   => 'Этот email уже используется другой компанией.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'           => 'название компании',
            'inn'            => 'ИНН',
            'contact_person' => 'контактное лицо',
            'phone'          => 'номер телефона',
            'email'          => 'email',
        ];
    }
}

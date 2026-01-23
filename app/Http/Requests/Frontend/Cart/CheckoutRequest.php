<?php

namespace App\Http\Requests\Frontend\Cart;


use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'delivery_date' => 'nullable|date',
        ];
    }
}

<?php

namespace App\Http\Requests\Admin\Orders;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'id'    => 'required|integer|exists:orders,id',
            'status' => 'required|integer',
            'delivery_date' => 'nullable|date_format:d/m/Y',
            'invoice' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png',]
        ];
    }
}
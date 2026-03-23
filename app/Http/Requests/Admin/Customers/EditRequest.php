<?php

namespace App\Http\Requests\Admin\Customers;

use App\Models\Customers;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255|unique:' . Customers::getTableName() . ',email,' . $this->id,
            'name' => 'required',
            'id' => 'required|integer|exists:' . Customers::getTableName() . ',id',
        ];
    }
}

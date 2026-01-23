<?php

namespace App\Http\Requests\Admin\Catalog;

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
            'id'   => 'required|integer|exists:catalogs,id',
            'name' => 'required',
            'slug' => 'required|unique:catalogs,slug,' . $this->id,
            'parent_id' => $this->parent_id > 0 ? 'nullable|integer|exists:catalogs,id' : 'nullable|integer',
        ];
    }
}

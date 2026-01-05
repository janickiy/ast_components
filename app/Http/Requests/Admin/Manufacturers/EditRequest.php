<?php

namespace App\Http\Requests\Admin\Manufacturers;

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
            'id'   => 'required|integer|exists:manufacturers,id',
            'title' => 'required',
            'slug'  => 'required|unique:manufacturers,slug,' . $this->id,
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
        ];
    }
}

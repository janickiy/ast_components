<?php

namespace App\Http\Requests\Admin\News;

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
            'id'      => 'required|integer|exists:news,id',
            'title'   => 'required',
            'slug'  => 'required|unique:manufacturers,slug,' . $this->id,
            'preview' => 'required',
            'text'    => 'required',
            'image'   => 'image|mimes:jpeg,jpg,png|min:800,max:2048|nullable',
        ];
    }
}
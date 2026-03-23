<?php

namespace App\Http\Requests\Admin\Pages;

use App\Models\Pages;
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
            'id'    => 'required|integer|exists:' . Pages::getTableName() . ',id',
            'title' => 'required',
            'text'  => 'required',
            'slug'  => 'required|unique:' . Pages::getTableName() . ',slug,' . $this->id,
            'main'  => 'integer|nullable'
        ];
    }
}
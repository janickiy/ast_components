<?php

namespace App\Http\Requests\Admin\News;

use App\Models\News;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title'   => 'required',
            'slug'    => 'required|unique:' . News::getTableName() . '',
            'preview' => 'required',
            'text'    => 'required',
            'image'   => 'image|mimes:jpeg,jpg,png|max:2048|nullable',
        ];
    }
}
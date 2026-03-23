<?php

namespace App\Http\Requests\Admin\Manufacturers;

use App\Models\Manufacturers;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:' . Manufacturers::getTableName() . ',id',
            'title' => 'required',
            'description' => 'required|string',
            'country' => 'required|string|max:100',
            'slug' => 'required|unique:' . Manufacturers::getTableName() . ',slug,' . $this->id,
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'seo_h1' => 'nullable|string',
            'seo_url_canonical' => 'nullable|string',
            'image_title' => 'nullable|string',
            'image_alt' => 'nullable|string',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
        ];
    }
}

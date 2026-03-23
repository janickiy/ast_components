<?php

namespace App\Http\Requests\Admin\News;

use App\Models\News;
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
            'id' => 'required|integer|exists:' . News::getTableName() . ',id',
            'title' => 'required',
            'slug' => 'required|unique:' . News::getTableName() . ',slug,' . $this->id,
            'preview' => 'required',
            'text' => 'required',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'seo_h1' => 'nullable|string',
            'seo_url_canonical' => 'nullable|string',
            'image_title' => 'nullable|string|max:80',
            'image_alt' => 'nullable|string|max:80',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048|nullable',
        ];
    }
}

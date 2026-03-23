<?php

namespace App\Http\Requests\Admin\Pages;

use App\Models\Pages;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'text' => 'required',
            'slug' => 'required|unique:' . Pages::getTableName(),
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'seo_h1' => 'nullable|string',
            'seo_url_canonical' => 'nullable|string',
            'main' => 'integer|nullable',
        ];
    }
}

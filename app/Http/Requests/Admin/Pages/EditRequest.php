<?php

namespace App\Http\Requests\Admin\Pages;

use App\Models\Pages;
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
            'id' => 'required|integer|exists:' . Pages::getTableName() . ',id',
            'title' => 'required',
            'text' => 'required',
            'slug' => 'required|unique:' . Pages::getTableName() . ',slug,' . $this->id,
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'seo_h1' => 'nullable|string',
            'seo_url_canonical' => 'nullable|string',
            'main' => 'integer|nullable',
        ];
    }
}

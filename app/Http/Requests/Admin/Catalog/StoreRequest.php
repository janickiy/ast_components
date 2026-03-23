<?php

namespace App\Http\Requests\Admin\Catalog;

use App\Models\Catalog;
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
            'name' => 'required',
            'slug' => 'required|unique:' . Catalog::getTableName(),
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'seo_h1' => 'nullable|string',
            'seo_url_canonical' => 'nullable|string',
            'parent_id' => 'integer|nullable',
        ];
    }
}

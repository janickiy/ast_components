<?php

namespace App\Http\Requests\Admin\Products;

use App\Models\Catalog;
use App\Models\Manufacturers;
use App\Models\Products;
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
            'id' => 'required|integer|exists:' . Products::getTableName() . ',id',
            'title' => 'required',
            'description' => 'required',
            'article' => 'required|unique:' . Products::getTableName() . ',article,' . $this->id,
            'n_number' => 'required|integer',
            'slug' => 'required|unique:' . Products::getTableName() . ',slug,' . $this->id,
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'seo_h1' => 'nullable|string',
            'seo_url_canonical' => 'nullable|string',
            'image_title' => 'nullable|string',
            'image_alt' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'catalog_id' => 'integer|required|exists:' . Catalog::getTableName() . ',id',
            'manufacturer_id' => 'integer|required|exists:' . Manufacturers::getTableName() . ',id',
            'in_stock' => 'nullable|integer',
            'under_order' => 'nullable|integer',
        ];
    }
}

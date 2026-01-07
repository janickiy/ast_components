<?php

namespace App\Http\Requests\Admin\Products;

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
            'id'    => 'required|integer|exists:products,id',
            'title' => 'required',
            'description' => 'required',
            'article'     => 'required|unique:products,article,' . $this->id,
            'n_number'    => 'required|integer',
            'slug'  => 'required|unique:products,slug,' . $this->id,
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
            'catalog_id'  => 'integer|required|exists:catalogs,id',
            'manufacturer_id' => 'integer|required|exists:manufacturers,id',
            'in_stock'    => 'nullable|integer',
            'under_order' => 'nullable|integer',
        ];
    }
}
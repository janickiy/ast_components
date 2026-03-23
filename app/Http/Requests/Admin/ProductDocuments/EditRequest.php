<?php

namespace App\Http\Requests\Admin\ProductDocuments;

use App\Models\ProductDocuments;
use App\Models\Products;
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
            'id'         => 'required|integer|exists:' . ProductDocuments::getTableName() . ',id',
            'file'       => 'nullable|file',
            'name'       => 'required',
            'product_id' => 'required|integer|exists:' . Products::getTableName() . ',id',
        ];
    }
}
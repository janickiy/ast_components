<?php

namespace App\Http\Requests\Admin\ProductDocuments;

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
            'file'       => 'required|file|mimes:jpg,png,doc,pdf,docx,txt,pdf,xls,xlsx,odt,ods',
            'name'       => 'required',
            'product_id' => 'required|integer|exists:products,id',
        ];
    }
}
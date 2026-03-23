<?php

namespace App\Http\Requests\Frontend\Cart;

use App\Models\Products;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:' . Products::getTableName() . ',id',
            'qty' => 'nullable|integer',
        ];
    }
}

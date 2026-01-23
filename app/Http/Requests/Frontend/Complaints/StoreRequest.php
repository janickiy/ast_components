<?php

namespace App\Http\Requests\Frontend\Complaints;

use App\Models\Complaints;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('customer')->check();
    }

    public function rules(): array
    {
        $customerId = (int) Auth::guard('customer')->id();
        return [
            'type' => ['required', 'integer', Rule::in(array_keys(Complaints::$type_name))],
            'order_id' => [
                'required',
                'integer',
                Rule::exists('orders', 'id')->where('customer_id', $customerId),
            ],
            'product_id' => [
                'required',
                'integer',
                Rule::exists('order_product', 'product_id')
                    ->where(fn ($query) => $query->where('order_id', $this->input('order_id'))),
            ],
            'return_count' => ['required', 'integer', 'min:1'],
            'claim_form' => ['nullable', 'file', 'max:5120'],
            'claim_photo' => ['nullable', 'file', 'max:5120'],
        ];
    }
}

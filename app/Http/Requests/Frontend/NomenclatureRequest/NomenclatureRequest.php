<?php

namespace App\Http\Requests\Frontend\NomenclatureRequest;

use Illuminate\Foundation\Http\FormRequest;

class NomenclatureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'company' => 'required',
            'name'    => 'required',
            'email'   => 'required|email',
            'phone'   => 'required',
            'nomenclature' => 'required',
            'count'   => 'required|integer|min:1',
            'unit'    => 'required',
            'agreement' => 'accepted',
        ];
    }
}
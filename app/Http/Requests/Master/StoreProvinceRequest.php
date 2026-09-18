<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProvinceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ProvinceID' => [
                'required',
                'string',
                'max:10',
                'unique:ms_province,ProvinceID',
            ],

            'CountryID' => [
                'required',
                'exists:ms_country,CountryID',
            ],

            'Province' => [
                'required',
                'string',
                'max:100',
            ],

            'IsActive' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}

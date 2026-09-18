<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProvinceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $provinceId = $this->route('province');

        return [
            'ProvinceID' => [
                'required',
                'string',
                'max:10',
                Rule::unique('ms_province', 'ProvinceID')
                    ->ignore($provinceId, 'ProvinceID'),
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

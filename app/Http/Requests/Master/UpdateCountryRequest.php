<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $countryId = $this->route('country');

        return [
            'CountryID' => [
                'required',
                'string',
                'size:3',
                'alpha_num',
                Rule::unique('ms_country', 'CountryID')
                    ->ignore($countryId, 'CountryID'),
            ],

            'Country' => [
                'required',
                'string',
                'max:100',
            ],

            'IsActive' => [
                'required',
                'boolean',
            ],
        ];
    }
}

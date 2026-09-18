<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReligionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ReligionID' => [
                'required',
                'string',
                'size:3',
                'alpha_num',
                Rule::unique('ms_religion', 'ReligionID'),
            ],

            'Religion' => [
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

    public function attributes(): array
    {
        return [
            'ReligionID' => 'Religion ID',
            'Religion' => 'Religion',
            'IsActive' => 'Status',
        ];
    }
}

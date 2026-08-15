<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = $this->route('company');

        return [

            'CompanyCode' => [

                'required',

                'max:20',

                Rule::unique(
                    'Ms_Company',
                    'CompanyCode'
                )->ignore(
                    $companyId,
                    'CompanyID'
                ),

            ],

            'CompanyName' => 'required|max:100',

            'Address' => 'nullable|max:255',

            'Phone' => 'nullable|max:30',

            'Email' => 'nullable|email',

            'IsActive' => 'required|boolean',

        ];
    }
}

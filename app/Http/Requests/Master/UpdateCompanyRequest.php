<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = $this->route('company');

        if (is_object($companyId)) {
            $companyId = $companyId->CompanyID;
        }

        return [
            'CompanyCode' => [
                'required',
                'string',
                'max:20',
                Rule::unique(
                    'ms_company',
                    'CompanyCode'
                )->ignore(
                    $companyId,
                    'CompanyID'
                ),
            ],

            'CompanyName' => [
                'required',
                'string',
                'max:200',
            ],

            'Address' => [
                'nullable',
                'string',
                'max:500',
            ],

            'Phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'Email' => [
                'nullable',
                'email',
                'max:100',
            ],

            'IsActive' => [
                'required',
                'boolean',
            ],
        ];
    }
}

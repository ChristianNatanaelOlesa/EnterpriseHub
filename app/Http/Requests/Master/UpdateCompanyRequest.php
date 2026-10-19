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
            $companyId = $companyId->CompID;
        }

        return [
            'CompID' => [
                'required',
                'string',
                'max:20',
                Rule::unique(
                    'ms_company',
                    'CompID'
                )->ignore(
                    $companyId,
                    'CompID'
                ),
            ],

            'Company' => [
                'required',
                'string',
                'max:200',
            ],

            'Description' => ['required', 'string'],

            'Address' => [
                'nullable',
                'string',
                'max:500',
            ],

            'Phone1' => ['required', 'string', 'max:30'],
            'Phone2' => ['nullable', 'string', 'max:30'],

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

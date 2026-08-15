<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'CompanyCode' => [
                'required',
                'string',
                'max:20',
                'unique:ms_company,CompanyCode',
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

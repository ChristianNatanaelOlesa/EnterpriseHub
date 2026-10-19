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
            'CompID' => [
                'required',
                'string',
                'max:20',
                'unique:ms_company,CompID',
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

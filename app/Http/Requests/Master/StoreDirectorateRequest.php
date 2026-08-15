<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDirectorateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'CompanyID' => [
                'required',
                'integer',
                Rule::exists(
                    'ms_company',
                    'CompanyID'
                )->where(function ($query) {
                    $query->where(
                        'IsActive',
                        true
                    );

                    $query->whereNull(
                        'DeletedDate'
                    );
                }),
            ],

            'DirectorateCode' => [
                'required',
                'string',
                'max:30',
                'unique:ms_directorate,DirectorateCode',
            ],

            'DirectorateName' => [
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

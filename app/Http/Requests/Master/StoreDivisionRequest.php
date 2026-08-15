<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDivisionRequest extends FormRequest
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
                'exists:ms_company,CompanyID',
            ],

            'DirectorateID' => [
                'required',
                'integer',
                Rule::exists(
                    'ms_directorate',
                    'DirectorateID'
                )->where(function ($query) {
                    $query->where(
                        'CompanyID',
                        $this->CompanyID
                    );
                    $query->where(
                        'IsActive',
                        true
                    );
                    $query->whereNull(
                        'DeletedDate'
                    );
                }),
            ],

            'DivisionCode' => [
                'required',
                'string',
                'max:30',
                'unique:ms_division,DivisionCode',
            ],

            'DivisionName' => [
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

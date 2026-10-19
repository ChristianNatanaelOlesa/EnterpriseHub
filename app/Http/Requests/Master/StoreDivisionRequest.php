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
            'CompID' => [
                'required',
                'string',
                'max:3',
                'exists:ms_company,CompID',
            ],

            'DirID' => [
                'required',
                'string',
                'max:3',
                Rule::exists(
                    'ms_directorate',
                    'DirID'
                )->where(function ($query) {
                    $query->where(
                        'CompID',
                        $this->CompID
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

            'DivID' => [
                'required',
                'string',
                'max:3',
                'unique:ms_division,DivID',
            ],

            'Division' => [
                'required',
                'string',
                'max:100',
            ],
            'Description' => ['required', 'string'],

            'IsActive' => [
                'required',
                'boolean',
            ],
        ];
    }
}

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
            'CompID' => [
                'required',
                'string',
                'max:3',
                Rule::exists(
                    'ms_company',
                    'CompID'
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

            'DirID' => [
                'required',
                'string',
                'max:3',
                'unique:ms_directorate,DirID',
            ],

            'Directorate' => [
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

<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDirectorateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $directorateId = $this->route('directorate');

        if (is_object($directorateId)) {
            $directorateId = $directorateId->DirectorateID;
        }

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
                Rule::unique(
                    'ms_directorate',
                    'DirectorateCode'
                )->ignore(
                    $directorateId,
                    'DirectorateID'
                ),
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

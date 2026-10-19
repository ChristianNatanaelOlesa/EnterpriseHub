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
            $directorateId = $directorateId->DirID;
        }

        return [
            'CompID' => [
                'required',
                'integer',
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
                'max:30',
                Rule::unique(
                    'ms_directorate',
                    'DirID'
                )->ignore(
                    $directorateId,
                    'DirID'
                ),
            ],

            'Directorate' => [
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

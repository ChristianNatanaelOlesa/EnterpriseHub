<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDivisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $divisionId = $this->route('division');

        if (is_object($divisionId)) {
            $divisionId = $divisionId->DivID;
        }

        return [
            'CompID' => [
                'required',
                'integer',
                'exists:ms_company,CompID',
            ],

            'DirID' => [
                'required',
                'integer',
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
                'max:30',
                Rule::unique(
                    'ms_division',
                    'DivID'
                )->ignore(
                    $divisionId,
                    'DivID'
                ),
            ],

            'Division' => [
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

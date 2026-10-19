<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DirectorateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $directorateId = $this->route('directorate');

        return [
            'CompID' => [
                'required',
                'integer',
                'exists:ms_company,CompID',
            ],

            'DirID' => [
                'required',
                'max:20',
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
                'max:200',
            ],

            'IsActive' => [
                'required',
                'boolean',
            ],
        ];
    }
}

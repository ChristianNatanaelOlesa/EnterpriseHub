<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DivisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $divisionId = $this->route('division');

        return [
            'DirID' => [
                'required',
                'integer',
                'exists:ms_directorate,DirID',
            ],

            'DivID' => [
                'required',
                'max:20',
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
                'max:200',
            ],

            'IsActive' => [
                'required',
                'boolean',
            ],
        ];
    }
}

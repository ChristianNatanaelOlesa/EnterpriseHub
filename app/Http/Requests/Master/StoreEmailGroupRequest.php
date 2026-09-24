<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmailGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'DivisionID' => [
                'required',
                'integer',
                'exists:ms_division,DivisionID',
            ],
            'Email' => [
                'required',
                'string',
                'max:100',
                'email',
            ],
            'Description' => [
                'required',
                'string',
            ],
            'IsGroup' => [
                'required',
                'boolean',
            ],
            'IsActive' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'DivisionID' => 'Division',
            'Email' => 'Email',
            'Description' => 'Description',
            'IsGroup' => 'Is Group',
            'IsActive' => 'Status',
        ];
    }
}

<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'Code' => [
                'required',
                'string',
                'max:30',
                'unique:sc_role,Code',
            ],

            'Name' => [
                'required',
                'string',
                'max:100',
            ],

            'Description' => [
                'nullable',
                'string',
                'max:255',
            ],

            'IsActive' => [
                'required',
                'boolean',
            ],

        ];
    }
}

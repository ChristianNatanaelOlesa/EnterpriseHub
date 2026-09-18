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

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'nullable',
                'array',
            ],

            'permissions.*.CanOpen' => [
                'nullable',
                'boolean',
            ],

            'permissions.*.CanAdd' => [
                'nullable',
                'boolean',
            ],

            'permissions.*.CanEdit' => [
                'nullable',
                'boolean',
            ],

            'permissions.*.CanDelete' => [
                'nullable',
                'boolean',
            ],

            'permissions.*.CanPrint' => [
                'nullable',
                'boolean',
            ],

            'permissions.*.CanExport' => [
                'nullable',
                'boolean',
            ],

            'permissions.*.CanApprove' => [
                'nullable',
                'boolean',
            ],

        ];
    }
}

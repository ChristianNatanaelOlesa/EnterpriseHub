<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $permissionId = $this->route('permission');

        return [
            'Name' => [
                'required', 'string', 'max:100',
                Rule::unique('sc_permission', 'Name')->ignore($permissionId, 'PermissionID'),
            ],
            'IsActive' => ['required', 'boolean'],
        ];
    }
}

<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        if (is_object($userId)) {
            $userId = $userId->UserID;
        }

        $activeRole = Rule::exists('sc_role', 'RoleID')->where(
            fn ($query) => $query->where('IsActive', true)->whereNull('DeletedDate')
        );

        return [
            'Username' => [
                'required', 'string', 'max:50',
                Rule::unique('sc_user', 'Username')->ignore($userId, 'UserID'),
            ],
            'FullName' => [
                'required', 'string', 'max:100',
            ],
            'Email' => [
                'required', 'email', 'max:100',
                Rule::unique('sc_user', 'Email')->ignore($userId, 'UserID'),
            ],
            'PhoneNumber' => [
                'nullable', 'string', 'max:30',
            ],
            'RoleIDs' => [
                'required', 'array', 'min:1',
            ],
            'RoleIDs.*' => [
                'required', 'string', 'size:5', 'distinct', $activeRole,
            ],
            'IsActive' => [
                'required', 'boolean',
            ],
        ];
    }
}

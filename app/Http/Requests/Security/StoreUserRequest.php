<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'Username' => [
                'required',
                'string',
                'max:50',
                'unique:sc_user,Username',
            ],

            'FullName' => [
                'required',
                'string',
                'max:100',
            ],

            'Email' => [
                'required',
                'email',
                'max:100',
                'unique:sc_user,Email',
            ],

            'PhoneNumber' => [
                'nullable',
                'string',
                'max:20',
            ],

            'Password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'roles' => [
                'nullable',
                'array',
            ],

            'roles.*' => [
                'integer',
                'exists:sc_role,RoleID',
            ],

            'IsActive' => [
                'required',
                'boolean',
            ],

        ];
    }
}

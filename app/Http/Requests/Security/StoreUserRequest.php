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
            'EmpFormID' => [
                'required',
                'string',
                'max:13',
                'exists:Tr_EmpForm,EmpFormID',
            ],

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
                'max:30',
            ],

            'RoleID' => [
                'required',
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

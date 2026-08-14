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

        return [

            'Username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sc_user', 'Username')->ignore($userId, 'UserID'),
            ],

            'FullName' => [
                'required',
                'string',
                'max:100',
            ],

            'Email' => [
                'required',
                'email',
                Rule::unique('sc_user', 'Email')->ignore($userId, 'UserID'),
            ],

            'PhoneNumber' => [
                'nullable',
                'string',
                'max:20',
            ],

            'RoleID' => [
                'required',
                'integer',
            ],

            'IsActive' => [
                'required',
                'boolean',
            ],

        ];
    }
}

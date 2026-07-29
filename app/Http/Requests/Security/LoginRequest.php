<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'Username' => ['required'],

            'Password' => ['required'],

        ];
    }
}

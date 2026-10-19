<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Name' => ['required', 'string', 'max:100', 'unique:sc_permission,Name'],
            'IsActive' => ['required', 'boolean'],
        ];
    }
}

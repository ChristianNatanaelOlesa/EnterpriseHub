<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ParentID'  => ['nullable', 'integer', 'exists:sc_menu,MenuID'],
            'Code'      => ['required', 'string', 'max:30', 'unique:sc_menu,Code'],
            'Name'      => ['required', 'string', 'max:100'],
            'Route'     => ['nullable', 'string', 'max:255'],
            'URL'       => ['nullable', 'string', 'max:255'],
            'Icon'      => ['nullable', 'string', 'max:100'],
            'SortOrder' => ['required', 'integer', 'min:0'],
            'IsMenu'    => ['nullable', 'boolean'],
            'IsActive'  => ['nullable', 'boolean'],
        ];
    }
}

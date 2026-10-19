<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ParentID'  => [
                'nullable', 'string', 'regex:/^\d{2}-\d{2}-\d{2}$/',
                Rule::exists('sc_menu', 'MenuID')->where(fn ($query) => $query->where('IsActive', true)->whereNull('DeletedDate')),
            ],
            'Menu'      => ['required', 'string', 'max:100'],
            'Description' => ['required', 'string'],
            'MenuArea'  => ['required', 'string', 'in:TOP,SIDEBAR', 'max:20'],
            'Route'     => ['nullable', 'string', 'max:255'],
            'Icon'      => ['nullable', 'string', 'max:100'],
            'SortOrder' => ['required', 'integer', 'min:0'],
            'IsMenu'    => ['nullable', 'boolean'],
            'IsActive'  => ['nullable', 'boolean'],
            'MenuID' => ['prohibited'],
            'Lvl' => ['prohibited'],
        ];
    }
}

<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $menuId = $this->route('menu');

        return [
            'ParentID' => [
                'nullable',
                'string',
                'regex:/^\d{2}-\d{2}-\d{2}$/',
                Rule::exists('sc_menu', 'MenuID')->where(fn ($query) => $query->where('IsActive', true)->whereNull('DeletedDate')),
                Rule::notIn([$menuId]),
            ],

            'Menu' => ['required', 'string', 'max:100'],
            'Description' => ['required', 'string'],
            'MenuArea' => ['required', 'string', 'in:TOP,SIDEBAR', 'max:20'],

            'Route' => [
                'nullable',
                'string',
                'max:255',
            ],

            'Icon' => [
                'nullable',
                'string',
                'max:100',
            ],

            'SortOrder' => [
                'required',
                'integer',
                'min:0',
            ],

            'IsMenu' => [
                'nullable',
                'boolean',
            ],

            'IsActive' => [
                'nullable',
                'boolean',
            ],
            'permission_ids' => ['nullable', 'array'],
            'MenuID' => ['prohibited'],
            'Lvl' => ['prohibited'],
            'permission_configuration_submitted' => ['nullable', 'boolean'],
            'permission_ids.*' => [
                'integer',
                'distinct',
                Rule::exists('sc_permission', 'PermissionID')
                    ->where(fn ($query) => $query->where('IsActive', true)->whereNull('DeletedDate')),
            ],
        ];
    }
}

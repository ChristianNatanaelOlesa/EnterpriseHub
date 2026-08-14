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
                'integer',
                'exists:sc_menu,MenuID',
                Rule::notIn([$menuId]),
            ],

            'Code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('sc_menu', 'Code')->ignore($menuId, 'MenuID'),
            ],

            'Name' => [
                'required',
                'string',
                'max:100',
            ],

            'Route' => [
                'nullable',
                'string',
                'max:255',
            ],

            'URL' => [
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
        ];
    }
}

<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'CompID' => [
                'required',
                'string',
                'max:3',
                'exists:ms_company,CompID',
            ],

            'DirID' => [
                'required',
                'string',
                'max:3',
                Rule::exists(
                    'ms_directorate',
                    'DirID'
                )->where(function ($query) {
                    $query
                        ->where(
                            'CompID',
                            $this->CompID
                        )
                        ->where(
                            'IsActive',
                            true
                        )
                        ->whereNull(
                            'DeletedDate'
                        );
                }),
            ],

            'DivID' => [
                'required',
                'string',
                'max:3',
                Rule::exists(
                    'ms_division',
                    'DivID'
                )->where(function ($query) {
                    $query
                        ->where(
                            'DirID',
                            $this->DirID
                        )
                        ->where(
                            'IsActive',
                            true
                        )
                        ->whereNull(
                            'DeletedDate'
                        );
                }),
            ],

            'DeptID' => [
                'required',
                'string',
                'max:3',
                'unique:ms_department,DeptID',
            ],

            'Department' => [
                'required',
                'string',
                'max:100',
            ],
            'Description' => ['required', 'string'],

            'IsActive' => [
                'required',
                'boolean',
            ],
        ];
    }
}

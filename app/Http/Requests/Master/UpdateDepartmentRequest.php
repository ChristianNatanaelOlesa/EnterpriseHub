<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('department');

        if (is_object($departmentId)) {
            $departmentId = $departmentId->DeptID;
        }

        return [
            'CompID' => [
                'required',
                'integer',
                'exists:ms_company,CompID',
            ],

            'DirID' => [
                'required',
                'integer',
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
                'integer',
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
                'max:30',
                Rule::unique(
                    'ms_department',
                    'DeptID'
                )->ignore(
                    $departmentId,
                    'DeptID'
                ),
            ],

            'Department' => [
                'required',
                'string',
                'max:100',
            ],

            'IsActive' => [
                'required',
                'boolean',
            ],
        ];
    }
}

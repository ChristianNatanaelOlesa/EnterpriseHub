<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('department');

        return [

            'DivID' => [
                'required',
                'integer',
                'exists:ms_division,DivID',
            ],

            'DeptID' => [
                'required',
                'string',
                'max:20',
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
                'max:200',
            ],

            'IsActive' => [
                'required',
                'boolean',
            ],

        ];
    }
}

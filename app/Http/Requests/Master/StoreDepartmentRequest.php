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
            'CompanyID' => [
                'required',
                'integer',
                'exists:ms_company,CompanyID',
            ],

            'DirectorateID' => [
                'required',
                'integer',
                Rule::exists(
                    'ms_directorate',
                    'DirectorateID'
                )->where(function ($query) {
                    $query
                        ->where(
                            'CompanyID',
                            $this->CompanyID
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

            'DivisionID' => [
                'required',
                'integer',
                Rule::exists(
                    'ms_division',
                    'DivisionID'
                )->where(function ($query) {
                    $query
                        ->where(
                            'DirectorateID',
                            $this->DirectorateID
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

            'DepartmentCode' => [
                'required',
                'string',
                'max:30',
                'unique:ms_department,DepartmentCode',
            ],

            'DepartmentName' => [
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

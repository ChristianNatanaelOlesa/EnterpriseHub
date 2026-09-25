<?php

namespace App\Http\Requests\EForm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmpInfraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'AccessArea' => 'Akun Windows',
        ]);
    }

    public function rules(): array
    {
        return [
            'ReqType' => [
                'required',
                'string',
                'in:Permanent,Temporary',
            ],

            'DateFrom' => [
                'required',
                'date_format:Y-m-d',
            ],

            'DateUntil' => [
                'required',
                'date_format:Y-m-d',
            ],

            'AccessType' => [
                'required',
                'string',
                'in:Personal,Server',
            ],

            'AccessArea' => [
                'required',
                'string',
                'max:200',
            ],

            'UserLogin' => [
                'required',
                'string',
                'max:100',

                Rule::unique(
                    'Tr_EmpInfra',
                    'UserLogin'
                )->ignore(
                    $this->route('employeeInfra'),
                    'EmpInfraID'
                ),
            ],

            'Purpose' => [
                'required',
                'string',
            ],

            'Notes' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            $reqType = $this->input('ReqType');

            $dateFrom = $this->input('DateFrom');

            $dateUntil = $this->input('DateUntil');


            /*
            |--------------------------------------------------------------------------
            | Permanent
            |--------------------------------------------------------------------------
            */

            if (
                $reqType === 'Permanent'
                && $dateUntil !== '1900-01-01'
            ) {

                $validator->errors()->add(
                    'DateUntil',
                    'Date Until untuk Permanent harus 01/01/1900.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Temporary
            |--------------------------------------------------------------------------
            */

            if (
                $reqType === 'Temporary'
                && $dateFrom
                && $dateUntil
                && $dateUntil < $dateFrom
            ) {

                $validator->errors()->add(
                    'DateUntil',
                    'Date Until tidak boleh lebih kecil dari Date From.'
                );
            }
        });
    }

    public function attributes(): array
    {
        return [
            'ReqType' => 'Request Type',
            'DateFrom' => 'Date From',
            'DateUntil' => 'Date Until',
            'AccessType' => 'Access Type',
            'AccessArea' => 'Access Area',
            'UserLogin' => 'User Login',
            'Purpose' => 'Purpose',
            'Notes' => 'Notes',
        ];
    }
}

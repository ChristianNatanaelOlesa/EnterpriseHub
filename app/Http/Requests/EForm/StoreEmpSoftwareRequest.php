<?php

namespace App\Http\Requests\EForm;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpSoftwareRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            'SoftType' => [
                'required',
                'string',
                'max:100',
            ],
            'SoftTool' => [
                'required',
                'string',
                'max:200',
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

            if (
                $reqType === 'Permanent' &&
                $dateUntil !== '1900-01-01'
            ) {
                $validator->errors()->add(
                    'DateUntil',
                    'Date Until untuk Permanent harus 01/01/1900.'
                );
            }

            if (
                $reqType === 'Temporary' &&
                $dateFrom &&
                $dateUntil &&
                $dateUntil < $dateFrom
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
            'SoftType' => 'Software Type',
            'SoftTool' => 'Software / Application',
            'Purpose' => 'Purpose',
            'Notes' => 'Notes',
        ];
    }
}

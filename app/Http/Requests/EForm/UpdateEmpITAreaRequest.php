<?php

namespace App\Http\Requests\EForm;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmpITAreaRequest extends FormRequest
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
            'DataCenter' => ['boolean'],
            'FingerPrint' => ['boolean'],
            'Firewall' => ['boolean'],
            'CCTV' => ['boolean'],
            'ExtDrive' => ['boolean'],
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
            if (
                $this->input('ReqType') === 'Permanent'
                && $this->input('DateUntil') !== '1900-01-01'
            ) {
                $validator->errors()->add(
                    'DateUntil',
                    'Date Until untuk Permanent harus 01/01/1900.'
                );
            }

            if (
                $this->input('ReqType') === 'Temporary'
                && $this->input('DateFrom')
                && $this->input('DateUntil')
                && $this->input('DateUntil') < $this->input('DateFrom')
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
            'DataCenter' => 'Data Center',
            'FingerPrint' => 'Finger Print',
            'Firewall' => 'Firewall',
            'CCTV' => 'CCTV',
            'ExtDrive' => 'External Drive',
            'Purpose' => 'Purpose',
            'Notes' => 'Notes',
        ];
    }
}

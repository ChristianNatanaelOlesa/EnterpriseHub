<?php

namespace App\Http\Requests\EForm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmpNetworkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $reqType = $this->input('ReqType') ?: 'Permanent';

        $this->merge([
            'ReqType' => $reqType,
            'DateFrom' => $this->input('DateFrom'),
            'DateUntil' => $reqType === 'Permanent'
                ? '1900-01-01'
                : $this->input('DateUntil'),
            'InternetAccess' => $this->boolean('InternetAccess'),
            'WLANAccess' => $this->boolean('WLANAccess'),
            'VPNAccess' => $this->boolean('VPNAccess'),
            'Purpose' => trim((string) $this->input('Purpose')) ?: 'Kebutuhan Pekerjaan',
            'Notes' => trim((string) $this->input('Notes')) ?: '-',
        ]);
    }

    public function rules(): array
    {
        return [
            'ReqType' => ['required', Rule::in(['Permanent', 'Temporary'])],
            'DateFrom' => ['required', 'date'],
            'DateUntil' => ['required', 'date'],
            'InternetAccess' => ['boolean'],
            'WLANAccess' => ['boolean'],
            'VPNAccess' => ['boolean'],
            'Purpose' => ['required', 'string', 'max:3000'],
            'Notes' => ['required', 'string', 'max:1000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $reqType = $this->input('ReqType');
            $dateFrom = $this->input('DateFrom');
            $dateUntil = $this->input('DateUntil');

            if ($reqType === 'Permanent' && $dateUntil !== '1900-01-01') {
                $validator->errors()->add(
                    'DateUntil',
                    'Permanent harus menggunakan 01/01/1900.'
                );
            }

            if ($reqType === 'Temporary') {
                if (!$dateUntil || $dateUntil === '1900-01-01') {
                    $validator->errors()->add(
                        'DateUntil',
                        'Temporary wajib memiliki Date Until.'
                    );
                } elseif ($dateFrom && $dateUntil < $dateFrom) {
                    $validator->errors()->add(
                        'DateUntil',
                        'Date Until tidak boleh kurang dari Date From.'
                    );
                }
            }
        });
    }

    public function attributes(): array
    {
        return [
            'ReqType' => 'Request Type',
            'DateFrom' => 'Date From',
            'DateUntil' => 'Date Until',
            'InternetAccess' => 'Internet Access',
            'WLANAccess' => 'WLAN Access',
            'VPNAccess' => 'VPN Access',
            'Purpose' => 'Purpose',
            'Notes' => 'Notes',
        ];
    }
}

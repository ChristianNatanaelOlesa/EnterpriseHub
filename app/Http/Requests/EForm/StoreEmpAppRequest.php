<?php

namespace App\Http\Requests\EForm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmpAppRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $reqType = $this->input('ReqType') ?: 'Permanent';
        $appType = $this->input('AppType') ?: 'Website';

        $this->merge([
            'ReqType' => $reqType,
            'Purpose' => $this->input('Purpose') ?: 'Kebutuhan Pekerjaan',
            'DateFrom' => $this->input('DateFrom') ?: now()->toDateString(),
            'DateUntil' => $reqType === 'Permanent'
                ? '1900-01-01'
                : $this->input('DateUntil'),
            'UserLogin' => trim((string) $this->input('UserLogin')) ?: '-',
            'UserPassword' => trim((string) $this->input('UserPassword')) ?: '-',
            'URL' => $appType === 'Website'
                ? trim((string) $this->input('URL')) ?: '-'
                : '-',
            'Notes' => trim((string) $this->input('Notes')) ?: '-',
        ]);
    }

    public function rules(): array
    {
        return [
            'ReqType' => ['required', Rule::in(['Permanent', 'Temporary'])],
            'Purpose' => ['required', 'string', 'max:3000'],
            'DateFrom' => ['required', 'date', 'after_or_equal:today'],
            'DateUntil' => ['required', 'date'],
            'UserLogin' => ['required', 'string', 'max:200'],
            'UserPassword' => ['required', 'string', 'max:200'],
            'AccessType' => ['required', Rule::in(['Internal', 'External'])],
            'AppType' => ['required', Rule::in(['Website', 'Aplikasi'])],
            'AppName' => ['required', 'string', 'max:300'],
            'URL' => ['required', 'string', 'max:1000'],
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

            if (
                $this->input('AppType') === 'Website' &&
                !filter_var($this->input('URL'), FILTER_VALIDATE_URL)
            ) {
                $validator->errors()->add(
                    'URL',
                    'URL Website harus berupa URL yang valid.'
                );
            }

            if ($this->input('AppType') === 'Aplikasi' && $this->input('URL') !== '-') {
                $validator->errors()->add(
                    'URL',
                    'URL untuk Aplikasi harus menggunakan "-".'
                );
            }
        });
    }

    public function attributes(): array
    {
        return [
            'ReqType' => 'Request Type',
            'Purpose' => 'Purpose',
            'DateFrom' => 'Date From',
            'DateUntil' => 'Date Until',
            'UserLogin' => 'User Login',
            'UserPassword' => 'User Password',
            'AccessType' => 'Access Type',
            'AppType' => 'Application Type',
            'AppName' => 'Application Name',
            'URL' => 'URL',
            'Notes' => 'Notes',
        ];
    }
}

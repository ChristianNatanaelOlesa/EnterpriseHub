<?php

namespace App\Http\Requests\EForm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmpEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ReqType' => $this->input('ReqType') ?: 'Permanent',
            'EmailType' => $this->input('EmailType') ?: 'Personal',
            'Purpose' => $this->input('Purpose') ?: 'Kebutuhan Pekerjaan',
            'DateUntil' => $this->input('ReqType') === 'Temporary'
                ? $this->input('DateUntil')
                : '1900-01-01',
        ]);

        if ($this->input('EmailType') === 'Personal') {
            $this->merge(['Email' => 'Fill by IT Infra']);
        }
    }

    public function rules(): array
    {
        $today = now()->toDateString();

        return [
            'ReqType' => ['required', Rule::in(['Permanent', 'Temporary'])],
            'EmailType' => ['required', Rule::in(['Personal', 'Corporate'])],
            'Email' => ['required', 'string', 'max:300'],
            'DateFrom' => ['required', 'date', 'after_or_equal:' . $today],
            'DateUntil' => ['required', 'date'],
            'Purpose' => ['required', 'string', 'max:3000'],
            'Notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('EmailType') === 'Corporate' && !filter_var($this->input('Email'), FILTER_VALIDATE_EMAIL)) {
                $validator->errors()->add('Email', 'Corporate Email harus berupa alamat email yang valid.');
            }

            $dateFrom = $this->input('DateFrom');
            $dateUntil = $this->input('DateUntil');
            $reqType = $this->input('ReqType');

            if ($reqType === 'Permanent' && $dateUntil !== '1900-01-01') {
                $validator->errors()->add('DateUntil', 'Permanent harus menggunakan 01/01/1900.');
            }

            if ($reqType === 'Temporary' && $dateFrom && $dateUntil) {
                if ($dateUntil === '1900-01-01') {
                    $validator->errors()->add('DateUntil', 'Temporary wajib memiliki Date Until.');
                } elseif ($dateUntil < $dateFrom) {
                    $validator->errors()->add('DateUntil', 'Date Until tidak boleh kurang dari Date From.');
                }
            }
        });
    }

    public function attributes(): array
    {
        return [
            'ReqType' => 'Request Type',
            'EmailType' => 'Email Type',
            'Email' => 'Email',
            'DateFrom' => 'Date From',
            'DateUntil' => 'Date Until',
            'Purpose' => 'Purpose',
            'Notes' => 'Notes',
        ];
    }
}

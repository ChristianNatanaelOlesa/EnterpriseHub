<?php

namespace App\Http\Requests\EForm;

use App\Models\EForm\TrEmpEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreEmpEmailRequest extends FormRequest
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
                Rule::in(['Permanent', 'Contract']),
            ],

            'EmailType' => [
                'required',
                'string',
                Rule::in(['Personal', 'Corporate']),
            ],

            'Email' => [
                'required',
                'string',
                'max:300',
            ],

            'DateFrom' => [
                'required',
                'date',
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

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            if ($this->input('EmailType') !== 'Personal') {
                return;
            }

            $empFormId = $this->user()?->EmpFormID;

            if (!$empFormId) {
                return;
            }

            $hasExistingPersonalEmail = TrEmpEmail::query()
                ->where('EmpFormID', $empFormId)
                ->where('EmailType', 'Personal')
                ->where('Status', '!=', 'REJECTED')
                ->exists();

            if ($hasExistingPersonalEmail) {
                $validator->errors()->add(
                    'EmailType',
                    'Anda masih memiliki request Personal Email yang masih aktif dan belum selesai. Selesaikan request sebelumnya terlebih dahulu.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'EmailType.required' => 'Email Type wajib dipilih.',
            'EmailType.in' => 'Email Type harus Personal atau Corporate.',
            'Email.required' => 'Email wajib diisi.',
            'DateFrom.required' => 'Date From wajib diisi.',
            'DateFrom.date' => 'Date From tidak valid.',
            'Purpose.required' => 'Purpose wajib diisi.',
            'ReqType.required' => 'Request Type wajib dipilih.',
        ];
    }
}

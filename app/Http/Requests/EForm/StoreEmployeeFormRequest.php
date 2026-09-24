<?php

namespace App\Http\Requests\EForm;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $firstName = preg_replace(
            '/\s+/',
            ' ',
            trim($this->input('FirstName', ''))
        );

        $lastName = preg_replace(
            '/\s+/',
            ' ',
            trim($this->input('LastName', ''))
        );

        $mobileNo = preg_replace(
            '/\D/',
            '',
            $this->input('MobileNo', '')
        );

        $mobileNo = ltrim($mobileNo, '0');

        if (str_starts_with($mobileNo, '62')) {
            $mobileNo = substr($mobileNo, 2);
        }

        $effectiveDate = $this->input('EffectiveDate');

        $this->merge([
            'FirstName' => ucwords(strtolower($firstName)),
            'LastName' => $lastName !== ''
                ? ucwords(strtolower($lastName))
                : null,
            'MobileNo' => $mobileNo !== ''
                ? '+62' . $mobileNo
                : null,
            'JoinDate' => $effectiveDate,
            'EmpStatus' => 'NEW',
        ]);
    }

    public function rules(): array
    {
        return [
            'FirstName' => ['required', 'string', 'max:300'],
            'LastName' => ['nullable', 'string', 'max:300'],
            'MobileNo' => ['required', 'regex:/^\+62[0-9]{8,15}$/'],
            'BirthDate' => ['required', 'date'],
            'NIP' => ['required', 'digits_between:1,30'],
            'MaritalStatus' => ['required', 'string', 'size:1'],
            'ReligionID' => ['required', 'string', 'size:3'],
            'JoinDate' => ['required', 'date'],
            'VillageID' => ['required', 'integer'],
            'Address' => ['required', 'string', 'max:1000'],
            'Email' => ['required', 'email', 'max:200'],
            'DirID' => ['required', 'integer'],
            'DivID' => ['required', 'integer'],
            'DeptID' => ['required', 'integer'],
            'JobLvlID' => ['required', 'integer'],
            'JobTitleID' => ['required', 'integer'],
            'ReportTo' => ['nullable', 'string', 'max:3'],
            'EmpStatus' => ['required', 'string', 'size:3', 'in:NEW'],
            'EffectiveDate' => ['required', 'date'],
            'Remarks' => ['required', 'string', 'max:1000'],
        ];
    }
}

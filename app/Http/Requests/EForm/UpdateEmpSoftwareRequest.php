<?php
namespace App\Http\Requests\EForm;
use Illuminate\Foundation\Http\FormRequest;
class UpdateEmpSoftwareRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return [
            'EmpFormID' => ['required','string','size:13','exists:Tr_EmpForm,EmpFormID'],
            'SourceType' => ['required','string','max:200'],
            'SoftwareName' => ['required','string','max:200'],
            'Version' => ['nullable','string','max:200'],
            'LicenseType' => ['nullable','string','max:200'],
            'Quantity' => ['required','integer','min:1'],
            'Notes' => ['nullable','string','max:1000'],
            'Status' => ['required','string','max:200'],
        ]; }
    public function attributes(): array { return [
            'EmpFormID' => 'Employee Form ID',
            'SourceType' => 'Source Type',
            'SoftwareName' => 'Software Name',
            'Version' => 'Version',
            'LicenseType' => 'License Type',
            'Quantity' => 'Quantity',
            'Notes' => 'Notes',
            'Status' => 'Status',
        ]; }
}

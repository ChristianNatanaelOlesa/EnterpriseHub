<?php
namespace App\Http\Requests\EForm;
use Illuminate\Foundation\Http\FormRequest;
class StoreEmpITAreaRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return [
            'EmpFormID' => ['required','string','size:13','exists:Tr_EmpForm,EmpFormID'],
            'SourceType' => ['required','string','max:200'],
            'EmailOnTablet' => ['boolean'],
            'EmailOnPhone' => ['boolean'],
            'Fingerprint' => ['boolean'],
            'CCTV' => ['boolean'],
            'Firewall' => ['boolean'],
            'ExternalDrive' => ['boolean'],
            'DataCenter' => ['boolean'],
            'Status' => ['required','string','max:200'],
        ]; }
    public function attributes(): array { return [
            'EmpFormID' => 'Employee Form ID',
            'SourceType' => 'Source Type',
            'EmailOnTablet' => 'Email on Tablet',
            'EmailOnPhone' => 'Email on Phone',
            'Fingerprint' => 'Fingerprint',
            'CCTV' => 'CCTV',
            'Firewall' => 'Firewall',
            'ExternalDrive' => 'External Drive',
            'DataCenter' => 'Data Center',
            'Status' => 'Status',
        ]; }
}

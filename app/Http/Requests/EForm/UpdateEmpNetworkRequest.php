<?php
namespace App\Http\Requests\EForm;
use Illuminate\Foundation\Http\FormRequest;
class UpdateEmpNetworkRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return [
            'EmpFormID' => ['required','string','size:13','exists:Tr_EmpForm,EmpFormID'],
            'SourceType' => ['required','string','max:200'],
            'WLAN' => ['boolean'],
            'Internet' => ['boolean'],
            'VPN' => ['boolean'],
            'Status' => ['required','string','max:200'],
        ]; }
    public function attributes(): array { return [
            'EmpFormID' => 'Employee Form ID',
            'SourceType' => 'Source Type',
            'WLAN' => 'WLAN',
            'Internet' => 'Internet',
            'VPN' => 'VPN',
            'Status' => 'Status',
        ]; }
}

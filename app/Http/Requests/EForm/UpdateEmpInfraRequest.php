<?php
namespace App\Http\Requests\EForm;
use Illuminate\Foundation\Http\FormRequest;
class UpdateEmpInfraRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return [
            'EmpFormID' => ['required','string','size:13','exists:Tr_EmpForm,EmpFormID'],
            'SourceType' => ['required','string','max:200'],
            'InfrastructureType' => ['required','string','max:200'],
            'Description' => ['nullable','string','max:1000'],
            'Status' => ['required','string','max:200'],
        ]; }
    public function attributes(): array { return [
            'EmpFormID' => 'Employee Form ID',
            'SourceType' => 'Source Type',
            'InfrastructureType' => 'Infrastructure Type',
            'Description' => 'Description',
            'Status' => 'Status',
        ]; }
}

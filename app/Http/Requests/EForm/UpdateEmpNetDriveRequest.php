<?php
namespace App\Http\Requests\EForm;
use Illuminate\Foundation\Http\FormRequest;
class UpdateEmpNetDriveRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return [
            'EmpFormID' => ['required','string','size:13','exists:Tr_EmpForm,EmpFormID'],
            'SourceType' => ['required','string','max:200'],
            'DriveName' => ['required','string','max:200'],
            'DrivePath' => ['required','string','max:200'],
            'AccessType' => ['required','string','max:200'],
            'Notes' => ['nullable','string','max:1000'],
            'Status' => ['required','string','max:200'],
        ]; }
    public function attributes(): array { return [
            'EmpFormID' => 'Employee Form ID',
            'SourceType' => 'Source Type',
            'DriveName' => 'Drive Name',
            'DrivePath' => 'Drive Path',
            'AccessType' => 'Access Type',
            'Notes' => 'Notes',
            'Status' => 'Status',
        ]; }
}

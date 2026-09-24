<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJobLevelRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('jobLevel');
        return [
            'JobLevel' => ['required', 'string', 'max:100', Rule::unique('ms_job_level', 'JobLevel')->ignore($id, 'JobLevelID')],
            'IsActive' => ['required', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return ['JobLevel' => 'Job Level', 'IsActive' => 'Status'];
    }
}

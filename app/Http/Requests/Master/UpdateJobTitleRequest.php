<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJobTitleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('jobTitle');
        return [
            'JobTitle' => ['required', 'string', 'max:200', Rule::unique('ms_job_title', 'JobTitle')->ignore($id, 'JobTitleID')],
            'IsActive' => ['required', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return ['JobTitle' => 'Job Title', 'IsActive' => 'Status'];
    }
}

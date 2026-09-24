<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobLevelRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'JobLevel' => ['required', 'string', 'max:100', Rule::unique('ms_job_level', 'JobLevel')],
            'IsActive' => ['required', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return ['JobLevel' => 'Job Level', 'IsActive' => 'Status'];
    }
}

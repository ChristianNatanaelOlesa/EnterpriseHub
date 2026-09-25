<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFolderPathRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'FolderName' => ['required', 'string', 'max:150'],
            'FolderPath' => ['required', 'string', 'max:500', 'unique:Ms_FolderPath,FolderPath'],
            'ParentFolderPathID' => [
                'nullable',
                'string',
                'max:10',
                Rule::exists('Ms_FolderPath', 'FolderPathID'),
            ],
            'IsActive' => ['nullable', 'boolean'],
        ];
    }
}

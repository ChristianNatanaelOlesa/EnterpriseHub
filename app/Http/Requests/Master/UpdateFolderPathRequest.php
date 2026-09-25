<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFolderPathRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('folder_path');

        return [
            'FolderName' => ['required', 'string', 'max:150'],
            'FolderPath' => [
                'required',
                'string',
                'max:500',
                Rule::unique('Ms_FolderPath', 'FolderPath')->ignore($id, 'FolderPathID'),
            ],
            'ParentFolderPathID' => [
                'nullable',
                'string',
                'max:10',
                Rule::exists('Ms_FolderPath', 'FolderPathID'),
                Rule::notIn([$id]),
            ],
            'IsActive' => ['nullable', 'boolean'],
        ];
    }
}

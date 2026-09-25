<?php

namespace App\Http\Requests\EForm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmpSharingFolderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ReqType' => ['required', 'in:Permanent,Temporary'],
            'DateFrom' => ['required', 'date_format:Y-m-d'],
            'DateUntil' => ['required', 'date_format:Y-m-d'],

            'FolderRequestType' => [
                'required',
                'in:Existing,New',
            ],

            'AccessType' => [
                'required',
                'in:Read,ReadWrite',
            ],

            'FolderPathIDs' => [
                'required_if:FolderRequestType,Existing',
                'array',
                'min:1',
            ],

            'FolderPathIDs.*' => [
                'string',
                Rule::exists('Ms_FolderPath', 'FolderPathID')
                    ->where(fn ($q) => $q->where('IsActive', true)),
            ],

            'ParentFolderPathID' => [
                'required_if:FolderRequestType,New',
                'nullable',
                Rule::exists('Ms_FolderPath', 'FolderPathID')
                    ->where(fn ($q) => $q->where('IsActive', true)),
            ],

            'NewFolderName' => [
                'required_if:FolderRequestType,New',
                'nullable',
                'string',
                'max:150',
            ],

            'Purpose' => ['required', 'string'],
            'Notes' => ['nullable', 'string'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $reqType = $this->input('ReqType');
            $dateFrom = $this->input('DateFrom');
            $dateUntil = $this->input('DateUntil');

            if ($reqType === 'Permanent' && $dateUntil !== '1900-01-01') {
                $validator->errors()->add(
                    'DateUntil',
                    'Date Until untuk Permanent harus 01/01/1900.'
                );
            }

            if (
                $reqType === 'Temporary'
                && $dateFrom
                && $dateUntil
                && $dateUntil < $dateFrom
            ) {
                $validator->errors()->add(
                    'DateUntil',
                    'Date Until tidak boleh lebih kecil dari Date From.'
                );
            }
        });
    }
}

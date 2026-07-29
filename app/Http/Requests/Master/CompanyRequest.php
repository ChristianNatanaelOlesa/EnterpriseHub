<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'CompanyCode' => [
                'required',
                'max:20',
                Rule::unique('ms_company', 'CompanyCode')->ignore($id, 'ID'),
            ],

            'CompanyName' => [
                'required',
                'max:200',
            ],

            'CompanyAlias' => [
                'nullable',
                'max:100',
            ],

            'IsActive' => [
                'boolean',
            ],
        ];
    }
}

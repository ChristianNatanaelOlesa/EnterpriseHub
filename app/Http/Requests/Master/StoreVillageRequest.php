<?php
namespace App\Http\Requests\Master;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreVillageRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array { return [
        'VillageID' => ['required','integer','min:1',Rule::unique('ms_village','VillageID')],
        'DistrictID' => ['required','string','max:10','exists:ms_district,DistrictID'],
        'Village' => ['required','string','max:100'],
        'PostalCode' => ['nullable','string','max:10'],
        'IsActive' => ['required','boolean'],
    ]; }
}


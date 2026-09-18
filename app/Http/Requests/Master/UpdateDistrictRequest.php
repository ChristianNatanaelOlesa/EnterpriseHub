<?php
namespace App\Http\Requests\Master;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateDistrictRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array { $id=$this->route('district'); return [
        'DistrictID' => ['required','string','max:10',Rule::unique('ms_district','DistrictID')->ignore($id,'DistrictID')],
        'CityID' => ['required','string','max:10','exists:ms_city,CityID'],
        'District' => ['required','string','max:100'],
        'IsActive' => ['required','boolean'],
    ]; }
}


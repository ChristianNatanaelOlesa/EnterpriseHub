<?php
namespace App\Http\Requests\Master;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateCityRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array { $id=$this->route('city'); return [
        'CityID' => ['required','string','max:10',Rule::unique('ms_city','CityID')->ignore($id,'CityID')],
        'ProvinceID' => ['required','string','max:10','exists:ms_province,ProvinceID'],
        'City' => ['required','string','max:100'],
        'IsActive' => ['required','boolean'],
    ]; }
}


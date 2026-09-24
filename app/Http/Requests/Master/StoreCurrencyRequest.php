<?php
namespace App\Http\Requests\Master;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreCurrencyRequest extends FormRequest{public function authorize():bool{return true;}public function rules():array{return ['CcyID'=>['required','string','max:10',Rule::unique('ms_currency','CcyID')],'Currency'=>['required','string','max:100'],'Priority'=>['required','integer','min:1'],'IsActive'=>['required','boolean']];}}

<?php
namespace App\Http\Requests\Master;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateCurrencyRequest extends FormRequest{public function authorize():bool{return true;}public function rules():array{$id=$this->route('currency');return ['CcyID'=>['required','string','max:10',Rule::unique('ms_currency','CcyID')->ignore($id,'CcyID')],'Currency'=>['required','string','max:100'],'Priority'=>['required','integer','min:1'],'IsActive'=>['required','boolean']];}}

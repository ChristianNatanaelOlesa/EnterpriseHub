<?php
namespace App\Http\Requests\Master;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreAssetGroupRequest extends FormRequest{public function authorize():bool{return true;}public function rules():array{return ['AssGroupID'=>['required','string','max:50',Rule::unique('ms_asset_group','AssGroupID')],'AssetGroup'=>['required','string','max:200'],'ComLifetime'=>['nullable','numeric','min:0'],'FiscalLifetime'=>['nullable','numeric','min:0'],'Description'=>['required','string'],'IsActive'=>['required','boolean']];}}

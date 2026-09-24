<?php
namespace App\Http\Requests\Master;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateAssetTypeRequest extends FormRequest{public function authorize():bool{return true;}public function rules():array{$id=$this->route('assetType');return ['AssTypeID'=>['required','string','max:50',Rule::unique('ms_asset_type','AssTypeID')->ignore($id,'AssTypeID')],'AssetGroupID'=>['required','string','exists:ms_asset_group,AssGroupID'],'AssetType'=>['required','string','max:150'],'TypeDesc'=>['required','string'],'IsActive'=>['required','boolean']];}}

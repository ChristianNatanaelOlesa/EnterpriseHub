<?php
namespace App\Http\Requests\Master;
use Illuminate\Foundation\Http\FormRequest;
class StoreParentFolderRequest extends FormRequest
{ public function authorize():bool{return true;} public function rules():array{return ['ParentFolderName'=>['required','string','max:150','unique:Ms_ParentFolder,ParentFolderName'],'ParentFolderPath'=>['required','string','max:500','unique:Ms_ParentFolder,ParentFolderPath'],'IsActive'=>['nullable','boolean']];} }

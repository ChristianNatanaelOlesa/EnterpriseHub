<?php
namespace App\Http\Requests\Master;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateParentFolderRequest extends FormRequest
{ public function authorize():bool{return true;} public function rules():array{ $id=$this->route('parent_folder'); return ['ParentFolderName'=>['required','string','max:150',Rule::unique('Ms_ParentFolder','ParentFolderName')->ignore($id,'ParentFolderID')],'ParentFolderPath'=>['required','string','max:500',Rule::unique('Ms_ParentFolder','ParentFolderPath')->ignore($id,'ParentFolderID')],'IsActive'=>['nullable','boolean']];} }

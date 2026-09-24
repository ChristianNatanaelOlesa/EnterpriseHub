<?php
namespace App\Http\Requests\EForm;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateEmpEquipRequest extends FormRequest
{
    public function authorize():bool{return true;}
    protected function prepareForValidation():void{$this->merge(['ReqType'=>$this->input('ReqType')?:'Permanent','Purpose'=>$this->input('Purpose')?:'Kebutuhan Pekerjaan','DateUntil'=>$this->input('ReqType')==='Temporary'?$this->input('DateUntil'):'1900-01-01']);}
    public function rules():array{return ['ReqType'=>['required',Rule::in(['Permanent','Temporary'])],'Purpose'=>['required','string','max:3000'],'AssetID'=>['required','string',Rule::exists('ms_asset','AssetID')->where(fn($q)=>$q->where('IsActive',true)->whereNull('DeletedDate'))],'DateFrom'=>['required','date'],'DateUntil'=>['required','date']];}
    public function withValidator($v):void{$v->after(function($v){$f=$this->input('DateFrom');$u=$this->input('DateUntil');if($this->input('ReqType')==='Permanent'&&$u!=='1900-01-01')$v->errors()->add('DateUntil','Permanent harus menggunakan 01/01/1900.');if($this->input('ReqType')==='Temporary'&&$f&&$u){if($u==='1900-01-01')$v->errors()->add('DateUntil','Temporary wajib memiliki Date Until.');elseif($u<$f)$v->errors()->add('DateUntil','Date Until tidak boleh kurang dari Date From.');}});}
    public function attributes():array{return ['ReqType'=>'Request Type','Purpose'=>'Purpose','AssetID'=>'Asset','DateFrom'=>'Date From','DateUntil'=>'Date Until'];}
}

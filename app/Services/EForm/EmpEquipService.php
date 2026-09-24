<?php
namespace App\Services\EForm;
use App\Models\EForm\TrEmpEquip;
use App\Models\EForm\TrEmpForm;
use App\Models\EForm\TrEmpFormHist;
use App\Models\Master\MsAsset;
use App\Models\Master\MsAssetType;
use App\Repositories\EForm\EmpEquipRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use RuntimeException;
class EmpEquipService
{
 public function __construct(protected EmpEquipRepository $repository){}
 public function getAll(?string $search=null,int $perPage=10):LengthAwarePaginator{return $this->repository->getAll($search,$perPage);}
 public function find(string $id):?TrEmpEquip{return $this->repository->find($id);}
 public function currentEmployeeForm():?TrEmpForm{$id=session('EmpFormID');return $id?TrEmpForm::query()->where('EmpFormID',$id)->first():null;}
 public function currentRequestDivisionId():?string{$id=session('EmpFormID');if(!$id)return null;return TrEmpFormHist::query()->where('EmpFormID',$id)->where('IsActive',true)->whereNotNull('DivID')->orderByDesc('EffectiveDate')->orderByDesc('ReqDate')->value('DivID');}
 public function getAssetTypes():Collection{return MsAssetType::query()->where('IsActive',true)->whereNull('DeletedDate')->orderBy('AssetType')->get(['AssTypeID','AssetType']);}
 public function getAvailableAssets(?string $typeId=null,?string $search=null):Collection{if(!$typeId)return collect();return MsAsset::query()->with('assetType')->where('AssTypeID',$typeId)->where('IsActive',true)->whereNull('DeletedDate')->when($search,function($q)use($search){$like="%{$search}%";$q->where(fn($x)=>$x->where('AssetID','like',$like)->orWhere('AssetDesc','like',$like)->orWhere('Brand','like',$like)->orWhere('Model','like',$like)->orWhere('SerialNo','like',$like));})->orderBy('AssetID')->get();}
 public function createMany(array $data,array $assetIds):int{return DB::transaction(function()use($data,$assetIds){$empFormId=session('EmpFormID');if(!$empFormId)throw new RuntimeException('User login belum memiliki EmpFormID pada session.');if(!TrEmpForm::query()->where('EmpFormID',$empFormId)->exists())throw new RuntimeException('EmpFormID pada session tidak ditemukan di Employee Form.');$div=$this->currentRequestDivisionId();if($div===null)throw new RuntimeException('Division aktif untuk Employee Form tidak ditemukan.');$now=now();$user=$this->username();$count=0;foreach(array_unique($assetIds) as $assetId){$asset=MsAsset::query()->where('AssetID',$assetId)->where('IsActive',true)->whereNull('DeletedDate')->lockForUpdate()->first();if(!$asset)throw ValidationException::withMessages(['AssetID'=>"Asset {$assetId} tidak tersedia atau sudah tidak aktif."]);$id=$this->generateId($data['DateFrom']);$this->repository->create(['EmpEquipID'=>$id,'EmpFormID'=>$empFormId,'ReqDivID'=>$div,'ReqUser'=>$user,'ReqDate'=>$now->toDateString(),'ReqType'=>$data['ReqType'],'Purpose'=>$data['Purpose'],'AssetID'=>$assetId,'DateFrom'=>$data['DateFrom'],'DateUntil'=>$data['DateUntil'],'IsGiven'=>false,'GivenDate'=>'1900-01-01','GivenNote'=>'-','IsReturn'=>false,'ReturnDate'=>'1900-01-01','ReturnNote'=>'-','CocID'=>'COC001','IsConfirm'=>false,'QRAppCoc'=>'-','Status'=>'DRAFT','InputUser'=>$user,'InputDate'=>$now,'ModifUser'=>$user,'ModifDate'=>$now]);$count++;}return $count;});}
 public function update(string $id,array $data):TrEmpEquip{return DB::transaction(function()use($id,$data){$m=TrEmpEquip::query()->where('EmpEquipID',$id)->lockForUpdate()->first();if(!$m)throw ValidationException::withMessages(['EmpEquipID'=>'Employee Equipment tidak ditemukan.']);$asset=MsAsset::query()->where('AssetID',$data['AssetID'])->where('IsActive',true)->whereNull('DeletedDate')->exists();if(!$asset)throw ValidationException::withMessages(['AssetID'=>'Asset yang dipilih tidak tersedia atau sudah tidak aktif.']);$m->update(['ReqType'=>$data['ReqType'],'Purpose'=>$data['Purpose'],'AssetID'=>$data['AssetID'],'DateFrom'=>$data['DateFrom'],'DateUntil'=>$data['DateUntil'],'ModifUser'=>$this->username(),'ModifDate'=>now()]);return $m->fresh(['empForm','asset.assetType']);});}
 public function delete(string $id):void{DB::transaction(function()use($id){$m=TrEmpEquip::query()->where('EmpEquipID',$id)->lockForUpdate()->first();if(!$m)throw ValidationException::withMessages(['EmpEquipID'=>'Employee Equipment tidak ditemukan.']);$m->delete();});}
 public function generateId(string $dateFrom):string{$prefix='EQP'.date('Ym',strtotime($dateFrom)).'-';$max=TrEmpEquip::query()->where('EmpEquipID','like',$prefix.'%')->selectRaw("MAX(CAST(SUBSTRING(EmpEquipID, 11, 3) AS UNSIGNED)) AS seq")->value('seq');return $prefix.str_pad((string)(((int)$max)+1),3,'0',STR_PAD_LEFT);}
 private function username():string{$u=Auth::user();return $u?->Username??$u?->username??$u?->email??'Admin';}
}

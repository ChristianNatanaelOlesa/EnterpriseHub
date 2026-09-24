<?php
namespace App\Services\Master;
use App\Repositories\Master\AssetRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class AssetService
{
 public function __construct(protected AssetRepository $repository){}
 public function getAll(?string $search=null){return $this->repository->search($search,10);}
 public function findById(string $id){return $this->repository->findById($id);}
 public function store(array $d){return DB::transaction(function()use($d){$d['AssetID']=$d['AssetID']??$this->generateAssetId();$d['QRCode']=$d['QRCode']??$d['AssetID'];$d['Notes']=blank($d['Notes']??null)?'-':$d['Notes'];$d['CcyID']=$d['CcyID']??'IDR';$d['ExchRate']=($d['CcyID']==='IDR')?1:($d['ExchRate']??1);$d['WarrantyDate']=empty($d['IsWarranty'])?'1900-01-01':($d['WarrantyDate']??'1900-01-01');$d['AcqCostIDR']=$d['AcqCostIDR']??(($d['AcqCost']??0)*($d['ExchRate']??1));return $this->repository->create($this->createAudit($d));});}
 public function update(string $id,array $d){return DB::transaction(function()use($id,$d){$d['Notes']=blank($d['Notes']??null)?'-':$d['Notes'];$d['ExchRate']=($d['CcyID']??'IDR')==='IDR'?1:($d['ExchRate']??1);$d['WarrantyDate']=empty($d['IsWarranty'])?'1900-01-01':($d['WarrantyDate']??'1900-01-01');$d['AcqCostIDR']=$d['AcqCostIDR']??(($d['AcqCost']??0)*($d['ExchRate']??1));return $this->repository->update($id,$this->updateAudit($d));});}
 public function delete(string $id){return DB::transaction(fn()=> $this->repository->update($id,['DeletedBy'=>auth()->user()->Username,'DeletedDate'=>now(),'IsActive'=>false]));}
 private function generateAssetId(){return 'AST'.now()->format('YmdHis').strtoupper(Str::random(3));}
 private function createAudit(array $d){$u=auth()->check()?auth()->user()->Username:'Admin';$d['InputUser']=$d['InputUser']??$u;$d['InputDate']=$d['InputDate']??now();$d['ModifUser']=$d['ModifUser']??$d['InputUser'];$d['ModifDate']=$d['ModifDate']??$d['InputDate'];return $d;}
 private function updateAudit(array $d){$d['ModifUser']=auth()->check()?auth()->user()->Username:'Admin';$d['ModifDate']=now();return $d;}
}

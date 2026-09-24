<?php
namespace App\Services\Master;
use App\Repositories\Master\AssetGroupRepository;
use Illuminate\Support\Facades\DB;
class AssetGroupService
{
 public function __construct(protected AssetGroupRepository $repository){}
 public function getAll(?string $search=null){return $this->repository->search($search,10);}
 public function findById(string $id){return $this->repository->findById($id);}
 public function store(array $data){return DB::transaction(fn()=> $this->repository->create($this->auditCreate($data)));}
 public function update(string $id,array $data){return DB::transaction(fn()=> $this->repository->update($id,$this->auditUpdate($data)));}
 public function delete(string $id){return DB::transaction(fn()=> $this->repository->update($id,['DeletedBy'=>auth()->user()->Username,'DeletedDate'=>now(),'IsActive'=>false]));}
 private function auditCreate(array $d){$u=auth()->check()?auth()->user()->Username:'Admin';$d['InputUser']=$d['InputUser']??$u;$d['InputDate']=$d['InputDate']??now();$d['ModifUser']=$d['ModifUser']??$d['InputUser'];$d['ModifDate']=$d['ModifDate']??$d['InputDate'];return $d;}
 private function auditUpdate(array $d){$d['ModifUser']=auth()->check()?auth()->user()->Username:'Admin';$d['ModifDate']=now();return $d;}
}

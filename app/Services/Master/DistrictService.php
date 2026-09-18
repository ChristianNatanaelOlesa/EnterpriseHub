<?php
namespace App\Services\Master;
use App\Repositories\Master\DistrictRepository;
use Illuminate\Support\Facades\DB;
class DistrictService { protected DistrictRepository $repository; public function __construct(DistrictRepository $repository){$this->repository=$repository;} public function search(?string $keyword=null,int $perPage=10){return $this->repository->search($keyword,$perPage);} public function findById(string $id){return $this->repository->findById($id);} public function create(array $data){return DB::transaction(function()use($data){$data['InputUser']=auth()->user()->UserID;$data['InputDate']=now();return $this->repository->create($data);});} public function update(string $id,array $data){return DB::transaction(function()use($id,$data){$data['ModifUser']=auth()->user()->UserID;$data['ModifDate']=now();return $this->repository->update($id,$data);});} public function delete(string $id){return DB::transaction(function()use($id){return $this->repository->update($id,['IsActive'=>false,'ModifUser'=>auth()->user()->UserID,'ModifDate'=>now(),'DeletedBy'=>auth()->user()->UserID,'DeletedDate'=>now()]);});} }


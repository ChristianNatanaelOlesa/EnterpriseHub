<?php
namespace App\Repositories\Master;
use App\Models\Master\MsVillage;
use App\Repositories\BaseRepository;
class VillageRepository extends BaseRepository {
    public function __construct(MsVillage $model){$this->model=$model;}
    public function search(?string $keyword=null,int $perPage=10){
        return $this->model->with('district.city')->when($keyword,function($q)use($keyword){$q->where(function($x)use($keyword){$x->where('VillageID','like',"%{$keyword}%")->orWhere('Village','like',"%{$keyword}%")->orWhere('PostalCode','like',"%{$keyword}%");});})->whereNull('DeletedDate')->orderBy('VillageID')->paginate($perPage)->withQueryString();
    }
    public function findById(int $id){return $this->model->with('district.city')->where('VillageID',$id)->whereNull('DeletedDate')->firstOrFail();}
}


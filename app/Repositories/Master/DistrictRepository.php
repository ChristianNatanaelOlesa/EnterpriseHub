<?php
namespace App\Repositories\Master;
use App\Models\Master\MsDistrict;
use App\Repositories\BaseRepository;
class DistrictRepository extends BaseRepository {
    public function __construct(MsDistrict $model){$this->model=$model;}
    public function search(?string $keyword=null,int $perPage=10){
        return $this->model->with('city.province')->when($keyword,function($q)use($keyword){$q->where(function($x)use($keyword){$x->where('DistrictID','like',"%{$keyword}%")->orWhere('District','like',"%{$keyword}%");});})->whereNull('DeletedDate')->orderBy('DistrictID')->paginate($perPage)->withQueryString();
    }
    public function findById(string $id){return $this->model->with('city.province')->where('DistrictID',$id)->whereNull('DeletedDate')->firstOrFail();}
}


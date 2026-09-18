<?php
namespace App\Repositories\Master;
use App\Models\Master\MsCity;
use App\Repositories\BaseRepository;
class CityRepository extends BaseRepository {
    public function __construct(MsCity $model){$this->model=$model;}
    public function search(?string $keyword=null,int $perPage=10){
        return $this->model->with('province.country')->when($keyword,function($q)use($keyword){$q->where(function($x)use($keyword){$x->where('CityID','like',"%{$keyword}%")->orWhere('City','like',"%{$keyword}%");});})->whereNull('DeletedDate')->orderBy('CityID')->paginate($perPage)->withQueryString();
    }
    public function findById(string $id){return $this->model->with('province.country')->where('CityID',$id)->whereNull('DeletedDate')->firstOrFail();}
}


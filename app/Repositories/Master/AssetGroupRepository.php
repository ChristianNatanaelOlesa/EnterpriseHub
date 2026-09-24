<?php
namespace App\Repositories\Master;
use App\Models\Master\MsAssetGroup;
use App\Repositories\BaseRepository;
class AssetGroupRepository extends BaseRepository
{
 public function __construct(MsAssetGroup $model){$this->model=$model;}
 public function search(?string $keyword=null,int $perPage=10){return $this->model->when($keyword,function($q)use($keyword){$q->where(function($x)use($keyword){$x->where('AssGroupID','like',"%{$keyword}%")->orWhere('AssetGroup','like',"%{$keyword}%")->orWhere('Description','like',"%{$keyword}%");});})->whereNull('DeletedDate')->orderBy('AssGroupID')->paginate($perPage)->withQueryString();}
 public function findById(string $id){return $this->model->where('AssGroupID',$id)->whereNull('DeletedDate')->firstOrFail();}
}
